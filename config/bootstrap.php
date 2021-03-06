<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

if (false === class_exists(Dotenv::class)) {
    throw new RuntimeException('Please run "composer require symfony/dotenv" to load the ".env" files configuring the application.');
}

$dotenv = new Dotenv(false);

// load all the .env files
if (false === method_exists($dotenv, 'loadEnv')) {
    throw new RuntimeException('Please upgrade "symfony/dotenv" component to "4.2" or higher version.');
}

$dotenv->loadEnv(dirname(__DIR__) . '/.env');

$_ENV['PROJECT_DIR'] = dirname(__DIR__);
