<?php

declare(strict_types=1);

use App\System\Kernel;

require dirname(__DIR__) . '/vendor/autoload.php';

$kernel = new Kernel();
$kernel->boot();
global $kernel;
