<?php

declare(strict_types=1);

namespace tests\integration\BOF;

use BOF\Application;
use Doctrine\DBAL\Connection;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Process\Process;
use tests\dictionary\BOF\Persistence;

abstract class DatabaseTestCase extends TestCase
{
    use Persistence;

    /** @var ContainerInterface */
    private $container;

    /** @var Connection */
    private $connection;

    protected function container(): ContainerInterface
    {
        return $this->container;
    }

    protected function connection(): Connection
    {
        return $this->connection;
    }

    protected function setUp()
    {
        $application = new Application();

        $this->container  = $application->getContainer();
        $this->connection = $this->container->get('database_connection');

        $this->setupDatabase();
    }

    protected function tearDown()
    {
        $this->container  = null;
        $this->connection = null;
    }

    private function setupDatabase()
    {
        $connection = $this->connection();
        $databases  = $connection->fetchAll(sprintf('SHOW DATABASES LIKE "%s";', $this->container()->getParameter('database_name')));

        if (empty($databases)) {
            $process = new Process('bin/setup-database');
            $process->run();

            return;
        }

        $connection->exec('TRUNCATE views; TRUNCATE profiles');
    }
}
