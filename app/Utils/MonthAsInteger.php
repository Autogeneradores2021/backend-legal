<?php

namespace App\Utils;


class MonthAsInteger
{

    /**
     * Convierte el nombre del mes a su valor entero.
     *
     * @param string $monthName
     * @return int
     */
    public static function getMonthAsInteger(string $monthName): int
    {
        $months = config("app.months");

        return (int) ($months[$monthName] ?? 0);
    }

}
