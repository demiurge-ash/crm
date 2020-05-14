<?php

namespace App\Http\Controllers;

use App\Event;
use App\Helpers\Helpers;
use App\Order;
use App\Time;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;

class HomeController extends Controller
{
    public function index(Guard $auth)
    {
        $user = $auth->user();

        $orders = Order::getRecent();

        $now = Carbon::now('Europe/Moscow')->format('Y-m-d');

        $vacations = Time::whereUserId($user->id)
            ->whereEvent(Event::VACATIONS)
            ->where('date', '>=', $now)
            ->orderBy('date')
            ->get();
        $vacationsPeriods = Helpers::makePeriods($vacations);

        return view('home', compact(
            'user',
            'orders',
            'vacationsPeriods'
        ));
    }


}
