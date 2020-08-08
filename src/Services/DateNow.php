<?php


namespace App\Services;


class DateNow
{
    public function getDate()
    {
        $date = date("d/m/Y H:i");
        return "Actual date is: " . $date;
    }
}