<?php

namespace App\Helpers;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Jenssegers\Date\Date;

class Calendar
{
    public static $calendarMonths = [
        '01' => 'Январь',
        '02' => 'Февраль',
        '03' => 'Март',
        '04' => 'Апрель',
        '05' => 'Май',
        '06' => 'Июнь',
        '07' => 'Июль',
        '08' => 'Август',
        '09' => 'Сентябрь',
        '10' => 'Октябрь',
        '11' => 'Ноябрь',
        '12' => 'Декабрь'
    ];

    public static function current($year, $month)
    {
        return Date::parse($year.'-'.$month);
    }

    public static function getDates($year, $month)
    {
        $dates = [];

        $selected = self::current($year, $month);

        $days = $selected->daysInMonth;

        for ( $i = 1; $i <= $days; $i++ ) {
            $current = Date::parse($year.'-'.$month.'-'.$i);
            $weekDay = $current->format('D');
            $day = $current->format('d');
            $dates[$day] = $weekDay;
        }
        return $dates;
    }

    public static function getWeek($period)
    {
        $dates = [];

        foreach ($period as $date) {
            $current = Date::parse($date);
            $weekDay = $current->format('D');
            $day = $current->format('d-m-Y');
            $dates[$day] = $weekDay;
        }
        return $dates;
    }

    public static function getFourWeeks( $firstDay=false )
    {
        $dates = [];

        if ( ! empty($firstDay->created_at))
            $now = Date::parse($firstDay->created_at);
        else
            $now = Date ::now();

        for ( $i = 1; $i <= 28; $i++ ) {
            $weekDay = $now->format('D');
            //$day = $now->format('d');
            $day = $now->format('d-m-Y');
            $dates[$day] = $weekDay;
            $now = $now->addDay();
        }
        return $dates;
    }

    public static function nameMonth($year, $month)
    {
        $selected = self::current($year, $month);
        return $selected->format('F Y');
    }

    public static function getRequestPeriod($request)
    {
        $dateBegin = $request->date_begin;
        $dateEnd = $request->date_end;

        return Calendar::getPeriod($dateBegin, $dateEnd);
    }

    public static function getPeriod($dateBegin, $dateEnd)
    {
        $period = CarbonPeriod::create($dateBegin, $dateEnd);

        $dates =[];
        foreach ($period as $date) {
            $dates[] = $date->format('Y-m-d');
        }
        return $dates;
    }

    public static function firstDayOfMonth($year, $month)
    {
        $selected = self::current($year, $month);
        return $selected->startOfMonth()->format('Y-m-d');
    }

    public static function endDayOfMonth($year, $month)
    {
        $selected = self::current($year, $month);
        return $selected->endOfMonth()->format('Y-m-d');
    }

    public static function calendarYears()
    {
        $beginYear = 2018;
        $endYear = date('Y') + 1;
        $years = array_combine(range($beginYear, $endYear),range($beginYear, $endYear));
        return $years;
    }

    public static function calendarMonths()
    {
        return self::$calendarMonths;
    }

    public static function nextMonth($year, $month)
    {
        $selected = self::current($year, $month);
        $nextMonth = $selected->addMonth()->format('Y-m');
        $nextMonthLink = str_replace('-', '/', $nextMonth);
        return $nextMonthLink;
    }

    public static function prevMonth($year, $month)
    {
        $selected = self::current($year, $month);
        $nextMonth = $selected->subMonth()->format('Y-m');
        $nextMonthLink = str_replace('-', '/', $nextMonth);
        return $nextMonthLink;
    }

    public static function sumTime($time1, $time2)
    {
        $times = array($time1, $time2);
        $seconds = 0;

        foreach ($times as $time) {
            list($hour,$minute) = explode(':', $time);
            $seconds += $hour*3600;
            $seconds += $minute*60;
        }

        $hours = floor($seconds/3600);
        $seconds -= $hours*3600;
        $minutes  = floor($seconds/60);

        if ($minutes < 9) {
            $minutes = "0".$minutes;
        }

        if ($hours < 9) {
            $hours = "0".$hours;
        }

        return "{$hours}:{$minutes}";
    }

    public static function removeSeconds($time)
    {
        return date('H:i', strtotime($time));
    }
}
