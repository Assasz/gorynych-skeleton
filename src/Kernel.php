<?php

declare(strict_types=1);

namespace App;

use Gorynych\Http\Kernel as Gorynych;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class Kernel extends Gorynych
{
    /**
     * {@inheritDoc}
     */
    public function getConfigLocator(): FileLocatorInterface
    {
        return new FileLocator(dirname(__DIR__) . '/config');
    }

    /**
     * {@inheritDoc}
     */
    protected function loadConfiguration(): void
    {
        $loader = new YamlFileLoader($this->container, $this->getConfigLocator());
        $loader->load(($this->env === 'test') ? 'services_test.yaml' : 'services.yaml');
    }
}
