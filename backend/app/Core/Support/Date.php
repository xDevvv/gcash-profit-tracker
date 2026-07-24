<?php

declare(strict_types=1);

namespace App\Core\Helpers;

use Carbon\Carbon;

final class Date
{
    private function __construct()
    {
    }

    public static function today(): Carbon
    {
        return Carbon::today();
    }

    public static function now(): Carbon
    {
        return Carbon::now();
    }

    public static function startOfWeek(): Carbon
    {
        return Carbon::now()->startOfWeek();
    }

    public static function endOfWeek(): Carbon
    {
        return Carbon::now()->endOfWeek();
    }

    public static function startOfMonth(): Carbon
    {
        return Carbon::now()->startOfMonth();
    }

    public static function endOfMonth(): Carbon
    {
        return Carbon::now()->endOfMonth();
    }
}
