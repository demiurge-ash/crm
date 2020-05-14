<?php

namespace App\Helpers;

use App\MontageSurface;
use App\Order;
use App\OrderPhotographer;
use App\OrderPromoter;
use App\PlacementSurface;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DataProcess
{
    public static function convertDatesSubModels($order, $id)
    {
        if ($order->orderType == 'visual-placement') {
            $order->surfaces = PlacementSurface::whereOrderId($id)->orderBy('sorting_order')->get();

        } else if ($order->orderType == 'visual-montage') {
            $order->surfaces = MontageSurface::whereOrderId($id)->orderBy('sorting_order')->get();

        } else if ($order->orderType == 'promo') {
            $order->promoters = OrderPromoter::whereOrderId($id)->orderBy('sorting_order')->get();
            Helpers::covertDatePeriod($order->promoters);
            $order = Helpers::deconvertBeginAndEndDates($order);

        } else if ($order->orderType == 'photo') {
            $order->photograpers = OrderPhotographer::whereOrderId($id)->orderBy('sorting_order')->get();
            Helpers::covertDatePeriod($order->photograpers);
            $order = Helpers::deconvertBeginAndEndDates($order);

        } else if ($order->orderType == 'radio') {
            $order = Helpers::deconvertBeginAndEndDates($order);
        }

        return $order;
    }

    public static function chooseTemplate($order)
    {
        if (Str::contains($order->orderType,'visual')) {
            return 'order';
        } else {
            return $order->orderType;
        }
    }

    public static function getBypassType($request)
    {
        $defaultBypassType = Order::$bypass[0];

        if ( ! $request->input('visual-bypass')) {
            return $defaultBypassType;
        }

        $type = $request->input('visual_bypass_type');
        if ( ! in_array($type, Order::$bypass) ) {
            return $defaultBypassType;
        }

        return $type;
    }
}