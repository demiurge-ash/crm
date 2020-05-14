<?php

namespace App\Http\Controllers;

use App\Event;
use App\Helpers\Calendar;
use App\Http\Requests\EventForm;
use App\Services\WorkTimeService;
use App\Time;
use App\User;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class TimeController extends Controller
{
    public function index()
    {
        $year = date('Y');
        $month = date('m');

        return redirect('/tracking/absent/'.$year.'/'.$month);
    }

    public function store(EventForm $request)
    {
        $dates = Calendar::getRequestPeriod($request);

        $events = [];
        foreach ($dates as $date) {
            $events[] = array(
                'event' => $request->event,
                'date' => $date,
                'user_id' => $request->user,
            );
        }

        if ( ! empty($events) && count($events)) {
            $cleanDates = array_map( function($event) { return $event['date']; }, $events );
            Time::whereIn('date', $cleanDates)->whereUserId($request->user)->delete();

            if ($request->event != Event::WORKDAY) {
                Time::insert($events);
            }
        }

        return redirect('/tracking/absent');
    }

    public function show($year, $month)
    {
        $dates = Calendar::getDates($year, $month);

        $users = User::select('id','name', 'active')->whereActive(1)->where('id', '!=', '1')->get();

        $monthHuman = Calendar::nameMonth($year, $month);

        $eventsTypes = Event::get();

        $firstDay = Calendar::firstDayOfMonth($year, $month);
        $endDay = Calendar::endDayOfMonth($year, $month);
        $events = Time::select('date','event','user_id')
            ->whereBetween('date', [$firstDay, $endDay])
            ->get()
            ->toArray();

        $workDays = WorkTimeService::workDays($firstDay, $endDay);

        $days = Calendar::getPeriod($firstDay, $endDay);

        $calendarMonths = Calendar::calendarMonths();
        $calendarYears = Calendar::calendarYears();

        $nextMonthLink = Calendar::nextMonth($year, $month);
        $prevMonthLink = Calendar::prevMonth($year, $month);

        return view('time', compact(
            'dates',
            'users',
            'monthHuman',
            'month',
            'year',
            'events',
            'eventsTypes',
            'calendarMonths',
            'calendarYears',
            'nextMonthLink',
            'prevMonthLink',
            'days',
            'workDays'
        ));
    }

}
