<?php

declare(strict_types=1);

namespace BOF\Infrastructure;

use BOF\Query\Month;
use BOF\Query\Profile;
use BOF\Query\YearlyReportQuery;
use Doctrine\DBAL\Connection;

class DBALYearlyReportQuery implements YearlyReportQuery
{
    /** @var Connection */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function get(int $year): array
    {
        $sql = <<<'STR'
SELECT
   p.profile_id,
   p.profile_name,
   Month(v.date) as month,
   SUM(v.views) as views 
FROM
   views AS v 
   JOIN
      profiles AS p 
      ON v.profile_id = p.profile_id 
WHERE
   YEAR(v.date) = :year 
GROUP BY
   p.profile_id,
   p.profile_name,
   Month(v.date) 
ORDER BY
   p.profile_id ASC
STR;

        $result = $this->connection->fetchAll($sql, ['year' => $year]);

        return array_reduce(
            $result,
            function (array $carry, array $profileData) {
                if (!isset($carry[$profileData['profile_id']])) {
                    $carry[$profileData['profile_id']] = new Profile(
                        (int) $profileData['profile_id'],
                        $profileData['profile_name'],
                        []
                    );
                }

                $carry[$profileData['profile_id']]->months = array_merge(
                    $carry[$profileData['profile_id']]->months,
                    [
                        $profileData['month'] => Month::fromNumber(
                            (int) $profileData['month'],
                            (int) $profileData['views']
                        ),
                    ]
                );

                return $carry;
            },
            []
        );
    }
}
