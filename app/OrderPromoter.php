<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helpers;
use Illuminate\Support\Str;

class OrderPromoter extends Model
{
    public static function getFromForm($request, $orderId, $update=false)
    {
        $input = $request->all();

        $promoters = array();
        $result = 0;

        // name format: promoter-number-1
        foreach ($input as $key => $value) {

            if (Str::startsWith($key, 'promoter-number-')){

                preg_match('/promoter-number-(\d*)/', $key, $matches);
                if (( ! empty($matches[1])) && ( ! empty($value))) {

                    $timestamp = Carbon::today()->toDateTimeString();
                    $promoters[] = array(
                        'order_id' => $orderId,
                        'sorting_order' => $matches[1],
                        'promoter' => $value,
                        'date_begin' => Helpers::convertDate($request->input('promoter-date-begin-'.$matches[1])),
                        'date_end' => Helpers::convertDate($request->input('promoter-date-end-'.$matches[1])),
                        'passport_serial' => $request->input('promoter-passport-serial-'.$matches[1]),
                        'passport_number' => $request->input('promoter-passport-number-'.$matches[1]),
                        'created_at' => $timestamp,
                        'updated_at' => $timestamp,
                    );
                }
            }
        }

        if ($update) OrderPromoter::whereOrderId($orderId)->delete();

        if( ! empty($promoters) && count($promoters)){
            OrderPromoter::insert($promoters);
            $result = count($promoters);
        }

        return $result;
    }
}
