<?php

namespace App\Http\Controllers;

use App\Helpers\Calendar;
use App\Helpers\Helpers;
use App\Services\WorkTimeService;
use App\TimeSchedule;
use App\User;
use App\Worktime;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkTimeController extends Controller
{
    public function index()
    {
        $dateUrl = WorkTimeService::makeWeekUrl();
        return redirect('/tracking/worktime/'.$dateUrl);
    }

    public function selectDays(Request $request)
    {
        $request->validate([
            'beginDate' => 'date_format:"Y-m-d"|required',
            'endDate' => 'date_format:"Y-m-d"|required',
            'user_id' => 'numeric|nullable'
        ]);

        $userUrl = $request->user_id ? '/'.$request->user_id : '';

        return redirect("/tracking/worktime/{$request->beginDate}/{$request->endDate}{$userUrl}");
    }

    public function show($beginDate, $endDate=null)
    {
        $beginDate = Carbon::parse($beginDate)->format('Y-m-d');

        if (is_null($endDate)) $endDate = $beginDate;
        else $endDate = Carbon::parse($endDate)->format('Y-m-d');

        $period = CarbonPeriod::create($beginDate, $endDate);

        $users = WorkTimeService::getUsers();

        $worktimes = Worktime::whereBetween('day', [$beginDate, $endDate])->get();

        $schedules = WorkTimeService::usersDaysSchedule($beginDate, $endDate, $period, $users);

        $days = [];
        foreach ($period as $day) {
            $day = $day->format('Y-m-d');
            $dayUsers = Helpers::cloneCollection($users);
            $days[$day] = WorkTimeService::usersStatistics($dayUsers, $worktimes, $day, $schedules);
        }

        return view('worktime.index', compact(
            'days',
            'beginDate',
            'endDate',
            'users'
        ));
    }

    public function showUser($beginDate, $endDate, $userId)
    {
        $beginDate = Carbon::parse($beginDate)->format('Y-m-d');
        $endDate = Carbon::parse($endDate)->format('Y-m-d');

        $period = CarbonPeriod::create($beginDate, $endDate);

        $users = WorkTimeService::getUsers();

        $currentUser = User::select('id','role_id','name','work_time_begin','work_time_end', 'avatar')
            ->whereId($userId)
            ->with('role')
            ->first();

        $worktimes = Worktime::whereUserId($userId)->whereBetween('day', [$beginDate, $endDate])->get();

        $schedule = WorkTimeService::userDaysSchedule($beginDate, $endDate, $period, $currentUser);

        $days = [];
        foreach ($period as $day) {
            $day = $day->format('Y-m-d');
            $dayUser = clone($currentUser);
            $days[$day] = WorkTimeService::userStatistics($dayUser, $worktimes, $day, $schedule[$day]);
        }

        $stats = WorkTimeService::summaryStatistics($days, $schedule);

        return view('worktime.user', compact(
            'days',
            'beginDate',
            'endDate',
            'users',
            'currentUser',
            'stats'
        ));
    }

    public function showWeek(Request $request)
    {
        $request->validate([
            'week' => 'date_format:"d-m-Y"|required',
        ]);

        $week = $request->week;
        $date = Carbon::create($week);
        $firstDayOfWeek = $date->startOfWeek()->format('Y-m-d H:i');
        $lastDayOfWeek = $date->endOfWeek()->format('Y-m-d H:i');

        $period = CarbonPeriod::create($firstDayOfWeek, $lastDayOfWeek);
        $dates = Calendar::getWeek($period);

        $users = User::where('id', '!=', '1')->whereActive(1)->get();

        $worktimes = Worktime::whereBetween('day', [$firstDayOfWeek, $lastDayOfWeek])->get();
        $fields = WorkTimeService::prepareFields($worktimes);

        return view('worktime.form-week', compact(
            'dates',
            'users',
            'week',
            'fields',
            'date'
        ));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'worktime_file' => 'required|mimes:xlsx,xls'
        ]);

        $import = WorkTimeService::uploadExcel($request->file('worktime_file'));

        Worktime::whereBetween('day', [$import->firstDay, $import->lastDay])->delete();

        if ( ! empty($import->worktimes) && count($import->worktimes)) {
            Worktime::insert($import->worktimes);
        }

        return redirect('/tracking/worktime/'.$import->firstDay.'/'.$import->lastDay)->with('status', 'Рабочее время учтено!');
    }

    public function select()
    {
        $date = Carbon::now();
        $firstDayOfWeek = $date->startOfWeek()->format('d-m-Y');

        return view('/worktime/select-week', compact('firstDayOfWeek'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'week' => 'date_format:"d-m-Y"|required',
        ]);

        WorkTimeService::cleanCurrentWeek($request->week);

        $worktimes = WorkTimeService::worktimes($request->all());

        if ( ! empty($worktimes) && count($worktimes)) {
            Worktime::insert($worktimes);
        }

        $dateUrl = WorkTimeService::makeWeekUrl($request->week);
        return redirect('/tracking/worktime/'.$dateUrl)->with('status', 'Рабочее время учтено!');
    }
}
