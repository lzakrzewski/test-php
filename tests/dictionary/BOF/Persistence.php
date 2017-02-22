<?php

declare(strict_types=1);

namespace tests\dictionary\BOF;

use Doctrine\DBAL\Connection;

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

    abstract protected function connection(): Connection;
}
