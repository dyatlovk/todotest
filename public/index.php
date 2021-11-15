<?php

declare(strict_types=1);

use App\System\Kernel;

require dirname(__DIR__) . '/vendor/autoload.php';

${Kernel::NAME} = new Kernel(Kernel::ENV_DEV);
${Kernel::NAME}->boot();
