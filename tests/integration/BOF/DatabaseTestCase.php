<?php

declare(strict_types=1);

namespace tests\integration\BOF;

use BOF\Application;
use Doctrine\DBAL\Connection;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Process\Process;

abstract class DatabaseTestCase extends TestCase
{
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

    protected function addProfile(int $profileId, string $profileName)
    {
        $this->connection()->insert('profiles', ['profile_id' => $profileId, 'profile_name' => $profileName]);
    }

    protected function addViews(int $profileId, string $date, int $views)
    {
        for ($idx = 1; $idx <= $views; ++$idx) {
            $this->connection()->insert(
                'views',
                [
                    'profile_id' => $profileId,
                    'date'       => sprintf('%s-%02d', $date, rand(1, 27)),
                    'views'      => 1,
                ]
            );
        }
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
