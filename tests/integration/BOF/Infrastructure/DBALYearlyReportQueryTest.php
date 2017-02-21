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

        $this->addViews(1, '2015-01', 300);
        $this->addViews(2, '2015-02', 100);
        $this->addViews(2, '2015-03', 150);

        $report = $this->query->get(2015);

        $this->assertEquals([
            1 => new Profile(
                1,
                'John Doe',
                [
                    Month::JAN(300),
                ]
            ),
            2 => new Profile(
                2,
                'Joan Doe',
                [
                    Month::FEB(100),
                    Month::MAR(150),
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
}
