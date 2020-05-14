<?php

namespace App\Http\Controllers;

use App\Helpers\Calendar;
use App\Http\Requests\ScheduleForm;
use App\Services\WorkTimeService;
use App\TimeSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TimeScheduleController extends Controller
{
    public function index()
    {
        $users = WorkTimeService::getUsers();

        $schedule = TimeSchedule::get();

        return view('schedule.index', compact('schedule', 'users'));
    }

    public function ajax(Request $request)
    {
        $model = TimeSchedule::query();

        if (intval($request->user) > 0) $model->whereUserId($request->user);

        $model->select('time_schedules.*')
            ->with('user')
            ->orderBy('date', 'desc');

        return DataTables::eloquent($model)
            ->editColumn('time_begin', function($item) {
                return date('H:i', strtotime($item->time_begin));
            })
            ->editColumn('time_end', function($item) {
                return date('H:i', strtotime($item->time_end));
            })
            ->editColumn('date', function($item) {
                return Carbon::parse($item->date)->format('d.m.Y');
            })
            ->make(true);
    }

    public function create()
    {
        $users = WorkTimeService::getUsers();

        return view('schedule.create', compact('users'));
    }

    public function store(ScheduleForm $request)
    {
        $schedule = new TimeSchedule();
        $schedule->user_id = $request->input('user_id');
        $schedule->time_begin = $request->input('time_begin');
        $schedule->time_end = $request->input('time_end');
        $schedule->date = $request->input('date');
        $schedule->save();

        return redirect('/tracking/schedule')->with('status', 'График рабочего времени добавлен!');
    }

    public function edit($id)
    {
        $users = WorkTimeService::getUsers();

        $current = TimeSchedule::whereId($id)->firstOrFail();
        $current->time_begin = Calendar::removeSeconds($current->time_begin);
        $current->time_end = Calendar::removeSeconds($current->time_end);

        return view('schedule.edit', compact('current', 'users'));
    }

    public function update(ScheduleForm $request)
    {
        $current = TimeSchedule::select('id')->whereId($request->id)->firstOrFail();
        TimeSchedule::find($current->id)->update($request->all());

        return redirect("/tracking/schedule")->with('status', 'Информация обновлена!');
    }
}
