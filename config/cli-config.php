<?php

use App\Infrastructure\Adapter\EntityManagerAdapter;
use App\Kernel;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Gorynych\Util\Debug;

require __DIR__ . '/bootstrap.php';

Debug::cli();

/** @var EntityManagerAdapter $managerAdapter */
$managerAdapter = (new Kernel())->boot()->getContainer()->get('entity_manager.adapter');

return ConsoleRunner::createHelperSet($managerAdapter->getManager());
