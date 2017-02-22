<?php

declare(strict_types=1);

namespace tests\unit\BOF\Query;

use BOF\Query\MonthView;
use BOF\Query\ProfileView;
use PHPUnit\Framework\TestCase;

class ProfileViewTest extends TestCase
{
    /** @test **/
    public function it_can_be_without_views()
    {
        $profile = ProfileView::withoutViews('John Doe');

        $this->assertEquals('John Doe', $profile->name());
        $this->assertCount(12, $profile->months());
    }

    /** @test **/
    public function it_can_be_add_views()
    {
        $profile = ProfileView::withoutViews('John Doe')
            ->withViewsIn(MonthView::JAN(111))
            ->withViewsIn(MonthView::FEB(222));

        $this->assertCount(12, $profile->months());
        $this->assertEquals($profile->months()[0], MonthView::JAN(111));
        $this->assertEquals($profile->months()[1], MonthView::FEB(222));

        for ($monthIdx = 2; $monthIdx <= 11; ++$monthIdx) {
            $this->assertEquals($profile->months()[$monthIdx], MonthView::fromNumber($monthIdx + 1, 0));
        }
    }

    /** @test **/
    public function it_has_raw_array_with_views_in_months()
    {
        $profile = ProfileView::withoutViews('John Doe')
            ->withViewsIn(MonthView::JAN(1))
            ->withViewsIn(MonthView::FEB(2))
            ->withViewsIn(MonthView::FEB(3))
            ->withViewsIn(MonthView::FEB(4))
            ->withViewsIn(MonthView::FEB(5))
            ->withViewsIn(MonthView::FEB(6))
            ->withViewsIn(MonthView::FEB(7))
            ->withViewsIn(MonthView::FEB(8))
            ->withViewsIn(MonthView::FEB(9))
            ->withViewsIn(MonthView::FEB(10))
            ->withViewsIn(MonthView::FEB(11))
            ->withViewsIn(MonthView::FEB(12));

        $this->assertEquals([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12], $profile->viewsInMonthsRaw());
    }
}
