<?php

declare(strict_types=1);

namespace App\Model;

use App\System\Kernel;
use PDO;

class User
{
    public function findByEmail(string $email): array
    {
        $conn = $this->getConnection();
        $sql = 'SELECT u.id as user_id, u.email as user_email, u.username as user_name, u.password as password FROM user u WHERE u.email = :email';
        $query = $conn->prepare($sql);
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch();
        if (false == $result) {
            return [];
        }

        return $result;
    }

    public function authenticate(array $formData): bool
    {
        $password = $formData['password'];
        $email = $formData['email'];
        $user = $this->findByEmail($email);
        if (false == $user) {
            return false;
        }
        if ($password === $user['password']) {
            $this->saveToSession($user);

            return true;
        }

        return false;
    }

    public function saveToSession(array $userData = []): bool
    {
        if (empty($userData)) {
            return false;
        }
        $_SESSION['user'] = $this->serialize($userData);

        return true;
    }

    public function loadFromSession(): ?array
    {
        if (isset($_SESSION['user'])) {
            return $this->unserialize($_SESSION['user']);
        }

        return null;
    }

    public function serialize(array $userData = []): string
    {
        return serialize($userData);
    }

    public function unserialize(string $userData): array
    {
        $data = unserialize($userData);
        if (!is_array($data)) {
            return [];
        }

        return $data;
    }

    public function isLogged(): bool
    {
        $user = $this->loadFromSession();
        if (empty($user)) {
            return false;
        }

        return true;
    }

    private function getConnection(): PDO
    {
        $app = Kernel::getInstance();

        return $app->getDbConnection();
    }
}
