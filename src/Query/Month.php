<?php

declare(strict_types=1);

namespace BOF\Query;

/**
 * @method static Month JAN(int $views)
 * @method static Month FEB(int $views)
 * @method static Month MAR(int $views)
 * @method static Month APR(int $views)
 * @method static Month MAY(int $views)
 * @method static Month JUNE(int $views)
 * @method static Month JULY(int $views)
 * @method static Month AUG(int $views)
 * @method static Month SEP(int $views)
 * @method static Month OCT(int $views)
 * @method static Month NOV(int $views)
 * @method static Month DEC(int $views)
 */
final class Month
{
    const MONTHS = [
        1  => 'JAN',
        2  => 'FEB',
        3  => 'MAR',
        4  => 'APR',
        5  => 'MAY',
        6  => 'JUNE',
        7  => 'JULY',
        8  => 'AUG',
        9  => 'SEP',
        10 => 'OCT',
        11 => 'NOV',
        12 => 'DEC',
    ];

    /** @var string */
    public $name;

    /** @var int */
    public $views;

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

    public static function fromNumber(int $number, int $views): self
    {
        return new self($number, $views);
    }
}
