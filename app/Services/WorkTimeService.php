<?php

namespace App\Services;

use App\Event;
use App\Helpers\Calendar;
use App\Imports\WorkTimeImport;
use App\TimeSchedule;
use App\User;
use App\Worktime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class WorkTimeService
{
    public static function usersStatistics($users, $worktimes, $day, $schedules)
    {
        foreach ($users as $user) {
            $user = WorkTimeService::userStatistics($user, $worktimes, $day, $schedules[$user->id][$day]);
        }
        return $users;
    }

    public static function userStatistics($user, $worktimes, $day, $schedule)
    {
        $user->work_time_begin = $schedule['time_begin'];
        $user->work_time_end = $schedule['time_end'];

        $user->work_time_begin = date('H:i', strtotime($user->work_time_begin));
        $work_time_begin = strtotime($user->work_time_begin);
        $time_in = $worktimes->where('user_id', $user->id)
            ->where('day', $day)
            ->where('direction', 'in')
            ->pluck('time')
            ->first();

        if ( ! empty($time_in)) {
            $time_in = strtotime($time_in);
            $user->worktime_in = date('H:i', $time_in);
            $diff = $time_in - $work_time_begin;
            if ($diff <= 0 ) {
                //$user->worktime_lateness = gmdate("H:i", abs($diff));
                //$user->worktime_lateness_color = 'text-success';
            } else {
                $user->worktime_lateness = gmdate("H:i", $diff);
                $user->worktime_lateness_color = 'text-danger';
            }
        }

        $user->work_time_end = date('H:i', strtotime($user->work_time_end));
        $work_time_end = strtotime($user->work_time_end);
        $time_out = $worktimes->where('user_id', $user->id)
            ->where('day', $day)
            ->where('direction', 'out')
            ->pluck('time')
            ->first();

        if ( ! empty($time_out)) {
            $time_out = strtotime($time_out);
            $user->worktime_out = date('H:i', $time_out);
            $diff = $time_out - $work_time_end;
            if ($diff >= 0 ) {
                //$user->worktime_early = gmdate("H:i", $diff);
                //$user->worktime_early_color = 'text-success';
            } else {
                $user->worktime_early = gmdate("H:i", abs($diff));
                $user->worktime_early_color = 'text-danger';
            }
        }

        $diff_norm = $work_time_end - $work_time_begin;
        if ( !empty($time_in) && !empty($time_out) ) {
            $diff_real_work = ($time_out - $time_in) - $diff_norm;
            if ($diff_real_work > 0 ) {
                $user->worktime_over = gmdate("H:i", $diff_real_work);
                $user->worktime_over_color = 'text-success';
            } elseif ($diff_real_work < 0 ) {
                $user->worktime_debt = gmdate("H:i", abs($diff_real_work));
                $user->worktime_debt_color = 'text-danger';
            }
        }

        return $user;
    }

    public static function prepareFields($worktimes)
    {
        $fields = [];
        foreach ($worktimes as $time) {
            $day = Carbon::create($time->day)->format('-d-m-Y');
            $fieldsName = "worktime-" . $time->direction . "-" . $time->user_id . $day;
            $fields[$fieldsName] = date('H:i', strtotime($time->time));
        }

        return $fields;
    }

    public static function makeWeekUrl($date=null)
    {
        if (is_null($date)) $date = Carbon::now()->subDays(6);

        $dateBegin = Carbon::parse($date)->format('Y-m-d');
        $dateEnd = Carbon::parse($date)->addDay(6)->format('Y-m-d');

        return $dateBegin.'/'.$dateEnd;
    }

    public static function worktimes($input)
    {
        $worktimes = [];

        // name format: worktime-in-2-27-01-2020
        foreach ($input as $key => $value) {

            if (Str::startsWith($key, 'worktime-')) {

                preg_match('/worktime-(in|out)-(\d*)-(\d*)-(\d*)-(\d*)/', $key, $matches);
                $direction = $matches[1];
                $userId = $matches[2];
                $day = $matches[3];
                $month = $matches[4];
                $year = $matches[5];

                if ((!empty($userId))
                    && (!empty($day))
                    && (!empty($month))
                    && (!empty($year))
                    && (!empty($value))) {

                    $date = Carbon::parse($day . '-' . $month . '-' . $year)->format('Y-m-d');

                    $checkIfUserExist = User::select('id')->whereId($userId)->firstOrFail();

                    $worktimes[] = array(
                        'user_id' => $userId,
                        'direction' => $direction,
                        'time' => $value,
                        'day' => $date
                    );
                }
            }
        }
        return $worktimes;
    }

    public static function cleanCurrentWeek($week)
    {
        $date = Carbon::create($week);

        $firstDayOfWeek = $date->startOfWeek()->format('Y-m-d');
        $lastDayOfWeek = $date->endOfWeek()->format('Y-m-d');

        Worktime::whereBetween('day', [$firstDayOfWeek, $lastDayOfWeek])->delete();
    }

    public static function getUsers()
    {
        return User::select('id','name','work_time_begin','work_time_end', 'avatar')
            ->where('id', '!=', '1')
            ->whereActive(1)
            ->get();
    }

    public static function summaryStatistics($days)
    {
        $stats = [];

        $countDays = count($days);
        $stats['days'] = $countDays . ' ' . Lang::choice('день|дня|дней', $countDays, [], 'ru');

        $wortimeFields = [
            'worktime_lateness',
            'worktime_early',
            'worktime_debt',
            'worktime_over'
        ];

        foreach ($wortimeFields as $field) {
            $stats = WorkTimeService::countTime($stats, $days, $field);
        }

        return $stats;
    }

    public static function countTime($stats, $days, $field)
    {
        $stats[$field] = '00:00';

        foreach ($days as $day) {
            if ( ! is_null($day->$field)) $stats[$field] = Calendar::sumTime($stats[$field], $day->$field);
        }

        if ($stats[$field] == '00:00') $stats[$field.'_color'] = 'default';

        return $stats;
    }

    public static function workDays($firstDay, $endDay)
    {
        $worktimes = Worktime::select('user_id','day')->whereBetween('day',[$firstDay, $endDay])->get();

        $workDays = [];
        foreach ($worktimes as $item) {
            $workDays[] = [
                'date' => $item->day,
                'event' => Event::WORKDAY,
                'user_id' => $item->user_id,
            ];
        }

        return $workDays;
    }

    public static function uploadExcel($file)
    {
        $import = new WorkTimeImport;

        try {
            Excel::import($import, $file);
        } catch (\Exception $e) {
            abort(403, 'Неверный формат документа');
        }

        return $import;
    }

    public static function usersDaysSchedule($beginDate, $endDate, $period, $users)
    {
        $schedules = [];
        foreach ($users as $user) {
            $schedules[$user->id] = WorkTimeService::userDaysSchedule($beginDate, $endDate, $period, $user);
        }
        return $schedules;
    }

    public static function userDaysSchedule($beginDate, $endDate, $period, $currentUser)
    {
        $firstDate = TimeSchedule::whereUserId($currentUser->id)->min('date');

        if (( ! empty($firstDate)) && ($firstDate <= $beginDate)) {
            $firstSchedule = TimeSchedule::select('date')
                ->whereUserId($currentUser->id)
                ->where('date', '<=', $beginDate)
                ->orderBy('date', 'desc')
                ->first();
            $firstScheduleDate = $firstSchedule->date;
        } else {
            $firstScheduleDate = $firstDate;
        }

        $fullSchedule = TimeSchedule::query()
            ->whereUserId($currentUser->id)
            ->whereBetween('date', [$firstScheduleDate, $endDate])
            ->orderBy('date')
            ->get();

        $schedule = [];
        foreach ($period as $day) {
            $day = $day->format('Y-m-d');
            $daySchedule = $fullSchedule->whereBetween('date', [$firstScheduleDate, $day])->last();

            $schedule[$day]['time_begin'] = $daySchedule->time_begin ?? $currentUser->work_time_begin;
            $schedule[$day]['time_end'] = $daySchedule->time_end ?? $currentUser->work_time_end;
        }

        return $schedule;
    }

}