<?php

declare(strict_types=1);

namespace tests\integration\BOF\Infrastructure;

use BOF\Infrastructure\DBALYearlyReportQuery;
use BOF\Query\Month;
use BOF\Query\Profile;
use tests\integration\BOF\DatabaseTestCase;

class DBALYearlyReportQueryTest extends DatabaseTestCase
{
    /** @var DBALYearlyReportQuery */
    private $query;

    /** @test **/
    public function it_cant_returns_yearly_report()
    {
        $this->addProfile(1, 'John Doe');
        $this->addProfile(2, 'Joan Doe');

        $this->addView(1, '2015-01-01', 3);
        $this->addView(2, '2015-01-02', 1);
        $this->addView(2, '2015-01-03', 1);

        $report = $this->query->get(2015);

        $this->assertEquals([
            new Profile(
                'John Doe',
                [
                    Month::JAN(3),
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
                    Month::JAN(2),
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
         ], $report);
    }

    protected function setUp()
    {
        parent::setUp();

        $this->query = $this->container()->get('app.query.report_yearly.dbal');
    }

    protected function tearDown()
    {
        $this->query = null;

        parent::tearDown();
    }

    private function addProfile(int $profileId, string $profileName)
    {
        $this->connection()->insert('profiles', ['profile_id' => $profileId, 'profile_name' => $profileName]);
    }

    private function addView(int $profileId, string $date, int $views)
    {
        $this->connection()->insert('views', ['profile_id' => $profileId, 'date' => $date, 'views' => $views]);
    }
}
