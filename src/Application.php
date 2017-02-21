<?php

declare(strict_types=1);

namespace BOF;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class Application extends ConsoleApplication
{
    /** @var ContainerBuilder */
    private $container;

    /**
     * @param string $name    The name of the application
     * @param string $version The version of the application
     */
    public function __construct($name = 'app', $version = '1')
    {
        $this->container = new ContainerBuilder();
        $loader          = new YamlFileLoader($this->container, new FileLocator(__DIR__.'/../app'));

        $loader->load('parameters.yml');
        $loader->load('config.yml');
        $loader->load('services.yml');

        // Initiate app
        parent::__construct($name, $version);

        // Add configured commands
        foreach ($this->getConfiguredCommands() as $command) {
            $this->add($command);
        }
    }

    /**
     * @return ContainerBuilder
     */
    public function getContainer(): ContainerBuilder
    {
        return $this->container;
    }

    /**
     * @return Command[] An array of default Command instances
     */
    private function getConfiguredCommands(): array
    {
        $commands = [];
        foreach ($this->container->findTaggedServiceIds('console.command') as $commandId => $command) {
            $commands[] = $this->container->get($commandId);
        }

        return $commands;
    }
}
