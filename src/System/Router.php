<?php

declare(strict_types=1);

namespace App\System;

use App\System\Templates;

class Router
{
    public const PUT = 'PUT';
    public const GET = 'GET';
    public const POST = 'POST';
    public const DELETE = 'DELETE';

    private static ?string $pathNotFound = null;
    private static ?string $methodNotAllowed = null;
    /** @var array<string> */
    private static array $routes = [];

    public static function add(string $uri, string $alias, array $method = self::GET, string $controller): void
    {
        array_push(self::$routes, [
            'expression' => $uri,
            'method' => $method,
            'controller' => $controller,
            'alias' => $alias,
        ]);
    }

    public static function pathNotFound(string $function): void
    {
        self::$pathNotFound = $function;
    }

    public static function methodNotAllowed(string $function): void
    {
        self::$methodNotAllowed = $function;
    }

    public static function findByAlias(?string $alias): ?array
    {
        if (empty($alias)) {
            return null;
        }
        $result = null;
        $routes = self::$routes;
        foreach ($routes as $route) {
            if ($alias === $route['alias']) {
                return $route;
            }
        }

        return $result;
    }

    public static function run(string $basepath = '/'): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $parsed_url = parse_url($_SERVER['REQUEST_URI']);
        $path = '/';
        if (isset($parsed_url['path'])) {
            $path = $parsed_url['path'];
        }
        foreach (self::$routes as $route) {
            if ('' !== $basepath && '/' !== $basepath) {
                $route['expression'] = '(' . $basepath . ')' . $route['expression'];
            }
            $route['expression'] = '^' . $route['expression'];
            $route['expression'] = $route['expression'] . '$';
            if (preg_match('#' . $route['expression'] . '#', $path, $matches)) {
                $path_match_found = true;
                if (in_array($method, $route['method'])) {
                    array_shift($matches);
                    if ('' !== $basepath && '/' !== $basepath) {
                        array_shift($matches);
                    }
                    $controllerName = $route['controller'];
                    $controllerParts = explode('::', $controllerName);
                    $controller = $controllerParts[0];
                    $controllerAction = $controllerParts[1];
                    $cont = new $controller();
                    echo (string) $cont->$controllerAction($matches);
                    return;
                }
            }
        }

        if (!$route_match_found) {
            if ($path_match_found) {
                header('HTTP/1.0 405 Method Not Allowed');
                echo (new Templates())->render('errors/403.php');
                if (self::$methodNotAllowed) {
                    call_user_func_array(self::$methodNotAllowed, [$path, $method]);
                }
            } else {
                header('HTTP/1.0 404 Not Found');
                echo (new Templates())->render('errors/404.php');
                if (self::$pathNotFound) {
                    call_user_func_array(self::$pathNotFound, [$path]);
                }
            }
        }
    }
}
