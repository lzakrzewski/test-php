<?php

declare(strict_types=1);

namespace tests\unit\BOF\Query;

use BOF\Query\Month;
use PHPUnit\Framework\TestCase;

class MonthTest extends TestCase
{
    /** @test @dataProvider months */
    public function it_can_be_created_with_static_constructor(Month $month, $expectedNumber)
    {
        $this->assertEquals($expectedNumber, $month->number);
        $this->assertEquals(1, $month->views);
    }

    public function months(): array
    {
        return [
            [Month::JAN(1), 1],
            [Month::FEB(1), 2],
            [Month::MAR(1), 3],
            [Month::APR(1), 4],
            [Month::MAY(1), 5],
            [Month::JUN(1), 6],
            [Month::JUL(1), 7],
            [Month::AUG(1), 8],
            [Month::SEP(1), 9],
            [Month::OCT(1), 10],
            [Month::NOV(1), 11],
            [Month::DEC(1), 12],
        ];
    }

    /** @test */
    public function it_can_be_created_from_number()
    {
        $month = Month::fromNumber(1, 99);

        $this->assertEquals(1, 1);
        $this->assertEquals(99, $month->views);
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
            Month::allTitleNames()
        );
    }
}
