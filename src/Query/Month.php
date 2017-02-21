<?php

declare(strict_types=1);

namespace BOF\Query;

final class Month
{
    /** @var string */
    public $name;

    /** @var int */
    public $views;

    /**
     * @param string $name
     * @param int    $views
     */
    public function __construct($name, $views)
    {
        $this->name  = $name;
        $this->views = $views;
    }

    public static function __callStatic(string $method, $arguments): self
    {
        return new self(self::titleName($method), $arguments);
    }

//    public static function JAN(int $views): self
//    {
//        return new self(self::titleName(__METHOD__), $views);
//    }

//    public static function FEB(int $views): self
//    {
//    }

//    public static function MAR(int $views): self
//    {
//    }

//    public static function APR(int $views): self
//    {
//    }

//    public static function MAY(int $views): self
//    {
//    }

//    public static function JUNE(int $views): self
//    {
//    }

//    public static function JULY(int $views): self
//    {
//    }

//    public static function AUG(int $views): self
//    {
//    }

//    public static function SEP(int $views): self
//    {
//    }

//    public static function OCT(int $views): self
//    {
//    }

//    public static function NOV(int $views): self
//    {
//    }

//    public static function DEC(int $views): self
//    {
//    }

    private static function titleName(string $name): string
    {
        return ucfirst(strtolower($name));
    }
}
