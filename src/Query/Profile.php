<?php

declare(strict_types=1);

namespace BOF\Query;

final class Profile
{
    /** @var int */
    public $id;

    /** @var string */
    public $name;

    /** @var array */
    public $months;

    public function __construct(int $id, string $name, array $months)
    {
        $this->name   = $name;
        $this->months = $months;
        $this->id     = $id;
    }
}
