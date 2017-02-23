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
    public function it_has_raw_array()
    {
        $profile = ProfileView::withoutViews('John Doe')
            ->withViewsIn(MonthView::JAN(12))
            ->withViewsIn(MonthView::FEB(13))
            ->withViewsIn(MonthView::MAR(14))
            ->withViewsIn(MonthView::APR(15))
            ->withViewsIn(MonthView::MAY(16))
            ->withViewsIn(MonthView::JUN(17))
            ->withViewsIn(MonthView::JUL(18))
            ->withViewsIn(MonthView::AUG(19))
            ->withViewsIn(MonthView::SEP(20))
            ->withViewsIn(MonthView::OCT(21))
            ->withViewsIn(MonthView::NOV(22))
            ->withViewsIn(MonthView::DEC(23));

        $this->assertEquals(['John Doe', 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23], $profile->rawArray());
    }
}
