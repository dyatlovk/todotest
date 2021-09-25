<?php

declare(strict_types=1);

namespace App\System;

class Router
{
    public const PUT = 'PUT';
    public const GET = 'GET';
    public const POST = 'POST';
    public const DELETE = 'DELETE';

    private static $pathNotFound = null;
    private static $methodNotAllowed = null;
    private static array $routes = [];

    public static function add(string $uri, string $method = self::GET, string $controller): void
    {
        array_push(self::$routes, [
            'expression' => $uri,
            'method' => $method,
            'controller' => $controller,
        ]);
    }

    public static function pathNotFound($function): void
    {
        self::$pathNotFound = $function;
    }

    public static function methodNotAllowed($function): void
    {
        self::$methodNotAllowed = $function;
    }

    public static function run(string $basepath = '/'): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $parsed_url = parse_url($_SERVER['REQUEST_URI']);
        if (isset($parsed_url['path'])) {
            $path = $parsed_url['path'];
        } else {
            $path = '/';
        }
        foreach (self::$routes as $route) {
            if ('' != $basepath && '/' != $basepath) {
                $route['expression'] = '(' . $basepath . ')' . $route['expression'];
            }
            $route['expression'] = '^' . $route['expression'];
            $route['expression'] = $route['expression'] . '$';
            if (preg_match('#' . $route['expression'] . '#', $path, $matches)) {
                $path_match_found = true;
                if (strtolower($method) == strtolower($route['method'])) {
                    array_shift($matches);
                    if ('' != $basepath && '/' != $basepath) {
                        array_shift($matches);
                    }
                    $controller = $route['controller'];
                    call_user_func($controller, $matches);
                    $route_match_found = true;
                    break;
                }
            }
        }

        if (!$route_match_found) {
            if ($path_match_found) {
                header('HTTP/1.0 405 Method Not Allowed');
                if (self::$methodNotAllowed) {
                    call_user_func_array(self::$methodNotAllowed, [$path, $method]);
                }
            } else {
                header('HTTP/1.0 404 Not Found');
                if (self::$pathNotFound) {
                    call_user_func_array(self::$pathNotFound, [$path]);
                }
            }
        }
    }
}
