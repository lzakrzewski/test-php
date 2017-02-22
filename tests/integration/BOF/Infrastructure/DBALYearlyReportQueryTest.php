<?php

declare(strict_types=1);

namespace tests\integration\BOF\Infrastructure;

use BOF\Infrastructure\DBALYearlyReportQuery;
use BOF\Query\MonthView;
use BOF\Query\ProfileView;
use tests\integration\BOF\DatabaseTestCase;

class DBALYearlyReportQueryTest extends DatabaseTestCase
{
    /** @var DBALYearlyReportQuery */
    private $query;

    /** @test **/
    public function it_can_return_yearly_report()
    {
        $this->persistProfile(1, 'John Doe');
        $this->persistProfile(2, 'Bruce Lee');

        $this->persistView(1, '2015-01-01', 3);
        $this->persistView(2, '2015-02-01', 5);
        $this->persistView(2, '2015-02-03', 3);
        $this->persistView(2, '2015-03-01', 7);

        $report = $this->query->get(2015);

        $this->assertCount(2, $report);
        $this->assertEquals(ProfileView::withoutViews('John Doe')->withViewsIn(MonthView::JAN(3)), $report[1]);
        $this->assertEquals(ProfileView::withoutViews('Bruce Lee')->withViewsIn(MonthView::FEB(5 + 3))->withViewsIn(MonthView::MAR(7)), $report[2]);
    }

    /** @test **/
    public function it_consider_only_views_from_given_year()
    {
        $this->persistProfile(1, 'John Doe');

        $this->persistView(1, '2014-12-31', 1);
        $this->persistView(1, '2015-01-01', 2);
        $this->persistView(1, '2015-12-31', 3);
        $this->persistView(1, '2016-01-01', 4);

        $report = $this->query->get(2015);
        $this->assertCount(1, $report);
        $this->assertEquals(ProfileView::withoutViews('John Doe')->withViewsIn(MonthView::JAN(2))->withViewsIn(MonthView::DEC(3)), $report[1]);
    }

    /** @test **/
    public function it_can_return_yearly_report_when_profile_name_is_duplicated()
    {
        $this->persistProfile(1, 'John Doe');
        $this->persistProfile(2, 'John Doe');

        $this->persistView(1, '2015-01-01', 11);
        $this->persistView(2, '2015-01-01', 22);

        $report = $this->query->get(2015);
        $this->assertCount(2, $report);
        $this->assertEquals(ProfileView::withoutViews('John Doe')->withViewsIn(MonthView::JAN(11)), $report[1]);
        $this->assertEquals(ProfileView::withoutViews('John Doe')->withViewsIn(MonthView::JAN(22)), $report[2]);
    }

    /** @test **/
    public function it_returns_empty_when_database_is_empty()
    {
        $this->assertEmpty($this->query->get(2015));
    }

    /** @test **/
    public function it_returns_empty_when_no_profiles()
    {
        $this->persistView(1, '2015-01-01', 11);
        $this->persistView(2, '2015-01-01', 22);

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
