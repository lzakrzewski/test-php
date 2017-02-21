<?php

declare(strict_types=1);

namespace BOF\Query;

interface YearlyReportQuery
{
    /**
     * @param int $year
     *
     * @return Profile[]
     */
    public function get(int $year): array;
}
