<?php

declare(strict_types=1);

namespace tests\dictionary\BOF;

use Doctrine\DBAL\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Process\Process;

trait Persistence
{
    protected function persistProfile(int $profileId, string $profileName)
    {
        $this->connection()->insert(
            'profiles',
            [
                'profile_id'   => $profileId,
                'profile_name' => $profileName,
            ]
        );
    }

    protected function persistView(int $profileId, string $date, int $views)
    {
        $this->connection()->insert(
            'views',
            [
                'profile_id' => $profileId,
                'date'       => $date,
                'views'      => $views,
            ]
        );
    }

    protected function setupDatabase()
    {
        $connection = $this->connection();
        $databases  = $connection->fetchAll(sprintf('SHOW DATABASES LIKE "%s";', $this->container()->getParameter('database_name')));

        if (empty($databases)) {
            $process = new Process('bin/setup-database');
            $process->run();
        }

        $connection->exec('SET FOREIGN_KEY_CHECKS = 0; TRUNCATE TABLE profiles; TRUNCATE TABLE views; SET FOREIGN_KEY_CHECKS = 1;');
    }

    abstract protected function connection(): Connection;

    abstract protected function container(): ContainerInterface;
}
