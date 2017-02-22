<?php

declare(strict_types=1);

namespace BOF\Query;

final class Profile
{
    /** @var string */
    public $name;

    /** @var array */
    public $months;

    private function __construct(string $name, array $months)
    {
        $this->name   = $name;
        $this->months = $months;
    }

    public static function withoutViews(string $name): self
    {
        return new self(
            $name,
            [
                Month::JAN(0),
                Month::FEB(0),
                Month::MAR(0),
                Month::APR(0),
                Month::MAY(0),
                Month::JUN(0),
                Month::JUL(0),
                Month::AUG(0),
                Month::SEP(0),
                Month::OCT(0),
                Month::NOV(0),
                Month::DEC(0),
            ]
        );
    }

    public function withViewsIn(Month $month): self
    {
        $this->months[$month->number - 1] = $month;

        return new self($this->name, $this->months);
    }
}
