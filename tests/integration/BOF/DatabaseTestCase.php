<?php

declare(strict_types=1);

namespace tests\integration\BOF;

use BOF\Application;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Process\Process;

abstract class DatabaseTestCase extends TestCase
{
    /** @var ContainerInterface */
    private $container;

    protected function container(): ContainerInterface
    {
        return $this->container;
    }

    protected function setUp()
    {
        $application = new Application();

        $this->container = $application->getContainer();

        $this->setupDatabase();
    }

    protected function tearDown()
    {
        $this->container = null;
    }

    private function setupDatabase()
    {
        $connection = $this->container()->get('database_connection');
        $databases  = $connection->fetchAll(sprintf('SHOW DATABASES LIKE "%s";', $this->container()->getParameter('database_name')));

        if (empty($databases)) {
            $process = new Process('bin/setup-database');
            $process->run();

            return;
        }

        $connection->exec('TRUNCATE views');
    }
}
