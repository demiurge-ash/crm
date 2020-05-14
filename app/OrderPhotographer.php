<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helpers;
use Illuminate\Support\Str;

class OrderPhotographer extends Model
{
    public static function getFromForm($request, $orderId, $update=false)
    {
        $input = $request->all();

        $photographer = array();
        $result = 0;

        // name format: photographer-number-1
        foreach ($input as $key => $value) {

            if (Str::startsWith($key, 'photographer-number-')){

                preg_match('/photographer-number-(\d*)/', $key, $matches);
                if (( ! empty($matches[1])) && ( ! empty($value))) {

                    $timestamp = Carbon::today()->toDateTimeString();
                    $photographer[] = array(
                        'order_id' => $orderId,
                        'sorting_order' => $matches[1],
                        'photographer' => $value,
                        'date_begin' => Helpers::convertDate($request->input('photographer-date-begin-'.$matches[1])),
                        'date_end' => Helpers::convertDate($request->input('photographer-data-end-'.$matches[1])),
                        //'passport_serial' => $request->input('photographer-passport-serial-'.$matches[1]),
                        //'passport_number' => $request->input('photographer-passport-number-'.$matches[1]),
                        'created_at' => $timestamp,
                        'updated_at' => $timestamp,
                    );
                }
            }
        }

        if ($update) OrderPhotographer::whereOrderId($orderId)->delete();

        if( ! empty($photographer) && count($photographer)){
            OrderPhotographer::insert($photographer);
            $result = count($photographer);
        }
        return $result;
    }
}
