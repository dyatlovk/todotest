<?php

use App\System\Router;

Router::add('/', 'app:home', [Router::GET,Router::POST], 'App\Controller\HomepageController::index');
Router::add('/test', 'app:test', [Router::GET], 'App\Controller\HomepageController::test');
Router::add('/test/{\d+}', 'app:test_entry', [Router::GET], 'App\Controller\HomepageController::testEntry');

Router::run();
