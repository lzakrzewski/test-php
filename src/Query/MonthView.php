<?php

declare(strict_types=1);

namespace BOF\Query;

/**
 * @method static MonthView JAN(int $views)
 * @method static MonthView FEB(int $views)
 * @method static MonthView MAR(int $views)
 * @method static MonthView APR(int $views)
 * @method static MonthView MAY(int $views)
 * @method static MonthView JUN(int $views)
 * @method static MonthView JUL(int $views)
 * @method static MonthView AUG(int $views)
 * @method static MonthView SEP(int $views)
 * @method static MonthView OCT(int $views)
 * @method static MonthView NOV(int $views)
 * @method static MonthView DEC(int $views)
 */
final class MonthView
{
    const MONTHS = [
        1  => 'JAN',
        2  => 'FEB',
        3  => 'MAR',
        4  => 'APR',
        5  => 'MAY',
        6  => 'JUN',
        7  => 'JUL',
        8  => 'AUG',
        9  => 'SEP',
        10 => 'OCT',
        11 => 'NOV',
        12 => 'DEC',
    ];

    /** @var int */
    private $number;

    /** @var int */
    private $views;

    private function __construct(int $number, int $views)
    {
        $months = self::MONTHS;

        if (false === isset($months[$number])) {
            throw new \InvalidArgumentException(sprintf('%d is invalid month number', $number));
        }

        $this->number = $number;
        $this->views  = $views;
    }

    public static function __callStatic($name, array $arguments): self
    {
        $months = array_values(self::MONTHS);

        if (false === in_array($name, $months)) {
            throw new \InvalidArgumentException(sprintf('%s is invalid month name', $name));
        }

        return new self(array_flip(self::MONTHS)[$name], $arguments[0]);
    }

    public static function allTitleNames(): array
    {
        return array_map(function (string $name) {
            return ucfirst(strtolower($name));
        }, array_values(self::MONTHS));
    }

    public static function fromNumber(int $number, int $views): self
    {
        return new self($number, $views);
    }

    public function number(): int
    {
        return $this->number;
    }

    public function views(): int
    {
        return $this->views;
    }
}
