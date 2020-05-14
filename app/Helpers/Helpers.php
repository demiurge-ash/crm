<?php

namespace App\Helpers;

use App\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Jenssegers\Date\Date;

class Helpers
{
    public static function covertDatePeriod($items)
    {
        foreach ($items as $item) {
            $item = Helpers::deconvertBeginAndEndDates($item);
        }
        return $items;
    }

    public static function deconvertBeginAndEndDates($item)
    {
        $item->date_begin = Helpers::deconvertDate($item->date_begin);
        $item->date_end = Helpers::deconvertDate($item->date_end);
        return $item;
    }

    public static function deconvertDate($date)
    {
        if (empty($date)) return null;

        return \DateTime::createFromFormat('Y-m-d', $date)->format('d.m.Y');
    }

    public static function convertDate($date)
    {
        if (empty($date)) return null;

        return \DateTime::createFromFormat('d.m.Y', $date)->format('Y-m-d');
    }

    public static function humanDate($date)
    {
        return Date::parse($date)->format('j F Y');
    }

    public static function dateDiff($begin, $end)
    {
        $beginDate = Carbon::createFromFormat('Y-m-d', $begin);
        $endDate = Carbon::createFromFormat('Y-m-d', $end);
        $diff = $beginDate->diffInDays($endDate) + 1;
        $days = Lang::choice('день|дня|дней', $diff, [], 'ru');
        return $diff . ' ' . $days;
    }

    public static function makePeriods($vacations)
    {
        if ($vacations->isEmpty()) return false;

        $index = 0;
        $date_checker = '';
        $grouped = [];

        foreach ($vacations as $vacation) {

            $date = $vacation->date;
            $nextDay = Carbon::parse($date_checker)->addDay()->format('Y-m-d');

            if ( ! isset($grouped))
                $index = 0;
            elseif ( $date != $nextDay )
                ++$index;

            $grouped[ $index ][] = $date_checker = $date;
        }

        foreach ($grouped as $group) {

            $begin = current($group);
            $end = end($group);

            $beginHumanDate = Helpers::humanDate($begin);
            $endHumanDate = Helpers::humanDate($end);
            $dateDiff = Helpers::dateDiff($begin, $end);

            if ($begin == $end)
                $result[] = $beginHumanDate . " (" . $dateDiff . ")";
            else
                $result[] = $beginHumanDate . " — " . $endHumanDate . " (" . $dateDiff . ")";
        }

        return $result;
    }

    public static function percentage($price, $sale)
    {
        $percentage = ($price - ($price * $sale / 100 ));
        $totalPrice = number_format($percentage, 2, '.', '');
        return $totalPrice;
    }

    public static function removeID($collection)
    {
        return $collection->map(function ($item) {
            return collect($item)->except(['id']);
        });
    }

    public static function addTypeOfOrder($collection, $type)
    {
        return $collection->map(function ($item) use ($type) {
            $item['typeTemplate'] = $item['type'];
            $item['type'] = $type;
            return $item;
        });
    }

    public static function limitQuery($query, $limit, $dateBegin, $dateEnd)
    {
        if ($dateBegin && $dateEnd) {
            $query->whereBetween(DB::raw('DATE(created_at)'), array($dateBegin, $dateEnd));
        } else {
            $query->take( $limit );
        }
        return $query;
    }

    public static function getLimit($dateBegin, $dateEnd)
    {
        $limit = Order::ORDERS_PER_PAGE;
        if ($dateBegin && $dateEnd) $limit = false;
        return $limit;
    }

    public static function limitCollection($query, $limit)
    {
        if ($limit) $query = $query->take($limit);
        return $query;
    }

    public static function fileLink($file)
    {
        if ($file) {
            $filePath = Storage::url($file);
            return '<a href="' . $filePath . '" target="_blank" download>Скачать</a>';
        }
    }

    public static function getTitle($current)
    {
        if ( ! empty($current->order_id)) {
            $category = Order::applyCategory($current->orderType, $current->type);
            $title = "Редактирование заказа № " . $current->order_id . ' ('. $category .')';
        } else {
            $title = "Создание нового заказа";
        }

        return $title;
    }

    public static function link($orders)
    {
        foreach ($orders as $order) {
            if (Str::contains($order->type,'visual')) {
                $order->link = '/order';
            } else {
                $order->link = '/order/'.$order->type;
            }
        }
        return $orders;
    }

    public static function cloneCollection($collection)
    {
        $cloneCollection = clone ($collection);
        $cloneCollection->transform(function($item) { return clone $item; });
        return $cloneCollection;
    }

}