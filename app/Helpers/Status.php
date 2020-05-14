<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;

class Status
{
    public static function workStatus($order)
    {
        $limit = 3;
        $done = 'завершён';
        $process = 'в процессе';

        if ($order->type == 'promo' || $order->type == 'photo') {
            $status = $done;
        } else {
            $status = $order->confirmed ? $done : $process;
        }

        $daysAgo = Carbon::parse($order->order_date)->diffInDays();

        if ($daysAgo > $limit && $status == $process) {
            $status = '<span style="color: red" class="blinking">'
                . $status .
                '<br>' . $daysAgo . Status::getLangDays($daysAgo) .
                '</span>';
        }

        if ($status == $done) {
            $status = '<span style="color: green">' . $status . '</span>';
        }

        return $status;
    }

    public static function getLangDays($days)
    {
        return Lang::choice(' день| дня| дней', $days);
    }

    public static function getOrderStatus($order)
    {
        $done = 'order-done';
        $process = 'order-process';

        if ($order->type == 'promo' || $order->type == 'photo') {
            $status = $done;
        } else {
            $status = $order->confirmed ? $done : $process;
        }

        return $status;
    }
}