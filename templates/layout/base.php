<?php
use App\Model\User;

$userModel = new User();
$isAuth = $userModel->isLogged();
$user = $userModel->loadFromSession(); ?>
<!DOCTYPE html>
<html lang='ru'>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title><?php echo $this->block('title'); ?></title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/main.css">
</head>
<body <?php echo $this->block('body_attr'); ?>>
    <div class="container-fluid">
        <header class="d-flex py-3">
            <?php if($isAuth): ?>Logged as: <?php echo $user['user_email']; ?> <a href="/logout">Logout</a><?php endif; ?>
            <?php if(!$isAuth): ?><a href="/login">Login</a><?php endif; ?>
        </header>
    </div>

    <main>
        <?php echo $this->block('content'); ?>
    </main>

    <footer>
        <?php echo $this->render('layout/footer.php'); ?>
    </footer>
</body>
</html>
