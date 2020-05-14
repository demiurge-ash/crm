<?php

namespace App\Helpers;

use App\RadioPeriod;
use Carbon\Carbon;

class Radio
{
    public static function getPeriods($view)
    {
        if ($view != 'radio') return null;

        $periods = RadioPeriod::get();
        foreach ($periods as $item) {
            $item->begin = Carbon::parse($item->begin)->format('H:i');
            $item->end = Carbon::parse($item->end)->format('H:i');
        }

        return $periods;
    }

    public static function getCalendar($view, $current)
    {
        if ($view != 'radio') return null;

        $radioDays = Calendar::getFourWeeks($current);

        return $radioDays;
    }
}