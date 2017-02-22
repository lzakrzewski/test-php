<?php

declare(strict_types=1);

namespace tests\unit\BOF\Query;

use BOF\Query\Month;
use BOF\Query\Profile;
use PHPUnit\Framework\TestCase;

class ProfileTest extends TestCase
{
    /** @test **/
    public function it_can_be_without_views()
    {
        $profile = Profile::withoutViews('John Doe');

        $this->assertEquals('John Doe', $profile->name);
    }

    /** @test **/
    public function it_can_be_add_views()
    {
        $profile = Profile::withoutViews('John Doe')
            ->withViewsIn(Month::JAN(111))
            ->withViewsIn(Month::FEB(222));

        $this->assertEquals($profile->months[0], Month::JAN(111));
        $this->assertEquals($profile->months[1], Month::FEB(222));

        for ($monthIdx = 2; $monthIdx <= 11; ++$monthIdx) {
            $this->assertEquals($profile->months[$monthIdx], Month::fromNumber($monthIdx + 1, 0));
        }
    }
}
