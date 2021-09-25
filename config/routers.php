<?php

use App\System\Router;

Router::add('/', Router::GET, 'App\Controller\HomepageController::index');

// Tasks
Router::add('/task/(\d+)/edit', Router::GET, 'App\Controller\TasksController::edit');
Router::add('/task/(\d+)/show', Router::GET, 'App\Controller\TasksController::show');
Router::add('/task/(\d+)/update', Router::POST, 'App\Controller\TasksController::update');

// Security
Router::add('/login', Router::GET, 'App\Controller\SecurityController::login');
Router::add('/logout', Router::GET, 'App\Controller\SecurityController::logout');

Router::run();
