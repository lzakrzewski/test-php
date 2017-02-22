<?php

declare(strict_types=1);

namespace tests\unit\BOF\Query;

use BOF\Query\MonthView;
use PHPUnit\Framework\TestCase;

class MonthViewTest extends TestCase
{
    /** @test @dataProvider months */
    public function it_can_be_created_with_static_constructor(MonthView $month, $expectedNumber)
    {
        $this->assertEquals($expectedNumber, $month->number());
        $this->assertEquals(1, $month->views());
    }

    public function months(): array
    {
        return [
            [MonthView::JAN(1), 1],
            [MonthView::FEB(1), 2],
            [MonthView::MAR(1), 3],
            [MonthView::APR(1), 4],
            [MonthView::MAY(1), 5],
            [MonthView::JUN(1), 6],
            [MonthView::JUL(1), 7],
            [MonthView::AUG(1), 8],
            [MonthView::SEP(1), 9],
            [MonthView::OCT(1), 10],
            [MonthView::NOV(1), 11],
            [MonthView::DEC(1), 12],
        ];
    }

    /** @test */
    public function it_can_be_created_from_number()
    {
        $month = MonthView::fromNumber(1, 99);

        $this->assertEquals(1, $month->number());
        $this->assertEquals(99, $month->views());
    }

    /** @test **/
    public function it_has_all_months_title_names()
    {
        $this->assertEquals(
            [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'Jun',
                'Jul',
                'Aug',
                'Sep',
                'Oct',
                'Nov',
                'Dec',
            ],
            MonthView::allTitleNames()
        );
    }
}
