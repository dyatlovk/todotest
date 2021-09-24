<?php

declare(strict_types=1);

use App\System\Router;

require dirname(__DIR__) . '/vendor/autoload.php';

Router::add('/', Router::GET, 'App\Controller\HomepageController::index');

// Tasks
Router::add('/task/(\d+)/edit', Router::GET, 'App\Controller\TasksController::edit');
Router::add('/task/(\d+)/show', Router::GET, 'App\Controller\TasksController::show');

// Security
Router::add('/login', Router::GET, 'App\Controller\SecurityController::login');
Router::add('/logout', Router::GET, 'App\Controller\SecurityController::logout');

Router::run();
