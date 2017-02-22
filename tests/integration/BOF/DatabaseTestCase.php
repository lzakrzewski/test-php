<?php

declare(strict_types=1);

namespace tests\integration\BOF;

use BOF\Application;
use Doctrine\DBAL\Connection;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
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
}
