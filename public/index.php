<?php

require dirname(__DIR__) . '/config/bootstrap.php';

use App\Kernel;
use Gorynych\Util\Debug;
use Gorynych\Util\EnvAccess;
use Symfony\Component\HttpFoundation\Request;

Debug::web();

$kernel = new Kernel();
$kernel
    ->boot(EnvAccess::get('APP_ENV', 'dev'))
    ->handleRequest(Request::createFromGlobals())
    ->send();
$kernel->shutdown();
