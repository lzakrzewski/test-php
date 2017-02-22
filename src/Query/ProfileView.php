<?php

declare(strict_types=1);

namespace BOF\Query;

final class ProfileView
{
    /** @var string */
    private $name;

    /** @var array */
    private $months;

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
                MonthView::JAN(0),
                MonthView::FEB(0),
                MonthView::MAR(0),
                MonthView::APR(0),
                MonthView::MAY(0),
                MonthView::JUN(0),
                MonthView::JUL(0),
                MonthView::AUG(0),
                MonthView::SEP(0),
                MonthView::OCT(0),
                MonthView::NOV(0),
                MonthView::DEC(0),
            ]
        );
    }

    public function withViewsIn(MonthView $month): self
    {
        $this->months[$month->number() - 1] = $month;

        return new self($this->name, $this->months);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function months(): array
    {
        return $this->months;
    }

    public function rawArray(): array
    {
        return array_merge([$this->name], array_map(function (MonthView $monthView) {
            return $monthView->number();
        }, $this->months));
    }
}
