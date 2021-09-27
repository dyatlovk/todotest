<?php

use App\System\Router;

Router::add('/', Router::GET, 'App\Controller\HomepageController::index');

// Tasks
Router::add('/task/add', Router::GET, 'App\Controller\TasksController::add');
Router::add('/task/create', Router::POST, 'App\Controller\TasksController::create');
Router::add('/task/(\d+)/edit', Router::GET, 'App\Controller\TasksController::edit');
Router::add('/task/(\d+)/update', Router::POST, 'App\Controller\TasksController::update');
Router::add('/task/(\d+)/delete', Router::GET, 'App\Controller\TasksController::delete');

// Security
Router::add('/login', Router::GET, 'App\Controller\SecurityController::login');
Router::add('/logout', Router::GET, 'App\Controller\SecurityController::logout');
Router::add('/login/check', Router::POST, 'App\Controller\SecurityController::check');

Router::run();
