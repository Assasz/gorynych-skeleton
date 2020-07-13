<?php

require dirname(__DIR__) . '/config/bootstrap.php';

use App\Kernel;
use Gorynych\Util\Debug;
use Symfony\Component\HttpFoundation\Request;

Debug::web();

$kernel = (new Kernel())->boot($_ENV['APP_ENV'] ?? 'dev');
$kernel->handleRequest(Request::createFromGlobals())->send();
$kernel->shutdown();
