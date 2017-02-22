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
    public function it_can_return_yearly_report()
    {
        $this->addProfile(1, 'John Doe');
        $this->addProfile(2, 'Bruce Lee');

        $this->addViews(1, '2015-01-01', 3);
        $this->addViews(2, '2015-02-01', 5);
        $this->addViews(2, '2015-02-03', 3);
        $this->addViews(2, '2015-03-01', 7);

        $report = $this->query->get(2015);

        $this->assertCount(2, $report);
        $this->assertEquals(Profile::withoutViews('John Doe')->withViewsIn(Month::JAN(3)), $report[1]);
        $this->assertEquals(Profile::withoutViews('Bruce Lee')->withViewsIn(Month::FEB(5 + 3))->withViewsIn(Month::MAR(7)), $report[2]);
    }

    /** @test **/
    public function it_consider_only_views_from_given_year()
    {
        $this->addProfile(1, 'John Doe');

        $this->addViews(1, '2014-12-31', 1);
        $this->addViews(1, '2015-01-01', 2);
        $this->addViews(1, '2015-12-31', 3);
        $this->addViews(1, '2016-01-01', 4);

        $report = $this->query->get(2015);
        $this->assertCount(1, $report);
        $this->assertEquals(Profile::withoutViews('John Doe')->withViewsIn(Month::JAN(2))->withViewsIn(Month::DEC(3)), $report[1]);
    }

    /** @test **/
    public function it_can_return_yearly_report_when_profile_name_is_duplicated()
    {
        $this->addProfile(1, 'John Doe');
        $this->addProfile(2, 'John Doe');

        $this->addViews(1, '2015-01-01', 11);
        $this->addViews(2, '2015-01-01', 22);

        $report = $this->query->get(2015);
        $this->assertCount(2, $report);
        $this->assertEquals(Profile::withoutViews('John Doe')->withViewsIn(Month::JAN(11)), $report[1]);
        $this->assertEquals(Profile::withoutViews('John Doe')->withViewsIn(Month::JAN(22)), $report[2]);
    }

    /** @test **/
    public function it_returns_empty_when_database_is_empty()
    {
        $this->assertEmpty($this->query->get(2015));
    }

    /** @test **/
    public function it_returns_empty_when_no_profiles()
    {
        $this->addViews(1, '2015-01-01', 11);
        $this->addViews(2, '2015-01-01', 22);

        $this->assertEmpty($this->query->get(2015));
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
