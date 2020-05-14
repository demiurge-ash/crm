<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helpers;
use Illuminate\Support\Str;

class MontageSurface extends Model
{
    protected $fillable = [
        'montage_type',
        'order_id',
        'sorting_order',
        'name',
        'place',
        'quantity',
        'price',
        'sale',
        'paid',
        'total_price',
        'manager',
        'confirmed',
        'date_begin',
        'date_end'
    ];

    public $timestamps = true;

    public static $vueModels = [
        'montage_type',
        'quantity',
        'price',
        'sale',
        'paid',
        'total_price',
        'name',
        'place',
        'manager',
        'confirmed',
        'date_begin',
        'date_end'
    ];


    public static function getFromForm($request, $orderId, $update=false)
    {
        $input = $request->all();

        $surfaces = array();
        $result = 0;

        self::$orderDone = 1;

        // name format: montage-number-1
        foreach ($input as $key => $value) {

            if (Str::startsWith($key, 'montage-number-')){

                preg_match('/montage-number-(\d*)/', $key, $matches);

                if (( ! empty($matches[1])) && ( ! empty($value))) {

                    $price = $request->input('visual-montage-price-'.$matches[1]);

                    // do not save orders with empty price
                    if ($price == 0 ) continue;

                    $quantity = $request->input('visual-montage-quantity-'.$matches[1]);
                    $sale = $request->input('visual-montage-sale-'.$matches[1]);

                    $surfaces[] = array(
                        'order_id' => $orderId,
                        'sorting_order' => $matches[1],
                        'montage_type' => $request->input('visual-montage-type-'.$matches[1]),
                        'manager' => $request->input('visual-montage-manager-'.$matches[1]),
                        'confirmed' => $request->input('visual-montage-confirmed-'.$matches[1]),
//                        'date_begin' => Helpers::convertDate($request->input('visual-montage-date-begin-'.$matches[1])),
//                        'date_end' => Helpers::convertDate($request->input('visual-montage-date-end-'.$matches[1])),
                        'date_begin' => $request->input('visual-montage-date-begin-'.$matches[1]),
                        'date_end' => $request->input('visual-montage-date-end-'.$matches[1]),
                        'name' => $request->input('visual-montage-name-'.$matches[1]),
                        'place' => $request->input('visual-montage-place-'.$matches[1]),
                        'quantity' => $quantity,
                        'price' => $price,
                        'sale' => $sale,
                        'total_price' => Helpers::percentage(($quantity*$price), $sale),
                        'paid' => $request->input('visual-montage-paid-'.$matches[1]),
                        'created_at' => Carbon::now()
                    );
                    self::isSurfaceDone( $request->input('visual-montage-confirmed-'.$matches[1]) );
                }
            }
        }

        if ($update) MontageSurface::whereOrderId($orderId)->delete();

        if( ! empty($surfaces) && count($surfaces)){
            MontageSurface::insert($surfaces);
            $result = count($surfaces);
        }

        return $result;
    }

    public static $orderDone;

    public static function isSurfaceDone($confirmed)
    {
        $confirmed = is_null($confirmed) ? 0 : $confirmed;
        if (self::$orderDone) {
            self::$orderDone = $confirmed;
        }
        return self::$orderDone;
    }

    public static function checkTotalPrice($request)
    {
        $input = $request->all();
        $totalPrice = 0;
        foreach ($input as $key => $value) {
            if (Str::startsWith($key, 'visual-montage-total-price-')) {
                preg_match('/visual-montage-total-price-(\d*)/', $key, $matches);
                $totalPrice += $request->input('visual-montage-total-price-'.$matches[1]);
            }
        }
        return $totalPrice;
    }
}
