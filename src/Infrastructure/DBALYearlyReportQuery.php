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
        $result = $this->connection->fetchAll(
            'SELECT * FROM views WHERE date >= :startDate AND date <= :endDate',
            [
                'startDate' => (new \DateTime(sprintf('%s-01-01', $year)))->format('Y-m-d'),
                'endDate'   => (new \DateTime(sprintf('%s-12-31', $year)))->format('Y-m-d'),
            ]
        );

        return [
            new Profile(
                'John Doe',
                [
                    Month::JAN($result[0]['views']),
                    Month::FEB(0),
                    Month::MAR(0),
                    Month::APR(0),
                    Month::MAY(0),
                    Month::JUNE(0),
                    Month::JULY(0),
                    Month::JULY(0),
                    Month::AUG(0),
                    Month::SEP(0),
                    Month::OCT(0),
                    Month::NOV(0),
                    Month::DEC(0),
                ]
            ),
            new Profile(
                'Joan Doe',
                [
                    Month::JAN($result[1]['views'] + $result[2]['views']),
                    Month::FEB(0),
                    Month::MAR(0),
                    Month::APR(0),
                    Month::MAY(0),
                    Month::JUNE(0),
                    Month::JULY(0),
                    Month::JULY(0),
                    Month::AUG(0),
                    Month::SEP(0),
                    Month::OCT(0),
                    Month::NOV(0),
                    Month::DEC(0),
                ]
            ),
        ];
    }
}
