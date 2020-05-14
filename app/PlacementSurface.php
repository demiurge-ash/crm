<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helpers;
use Illuminate\Support\Str;

class PlacementSurface extends Model
{
    protected $fillable = [
        'order_id',
        'sorting_order',
        'quantity',
        'price',
        'cost',
        'sale',
        'paid',
        'total_price',
        'location',
        'adv_place',
        'date_begin',
        'date_end'
    ];

    public $timestamps = true;

    public static $vueModels = [
        'quantity',
        'price',
        'cost',
        'sale',
        'paid',
        'total_price',
        'location',
        'adv_place',
        'date_begin',
        'date_end'
    ];

    public static function getFromForm($request, $orderId, $update=false)
    {
        $input = $request->all();

        $surfaces = array();
        $result = 0;

        // name format: surface-number-1
        foreach ($input as $key => $value) {

            if (Str::startsWith($key, 'surface-number-')){

                preg_match('/surface-number-(\d*)/', $key, $matches);
                if ((!empty($matches[1])) && (!empty($value))) {
                    $price = $request->input('visual-placement-price-'.$matches[1]);
                    if ($price == 0 ) continue; // do not save orders with empty price
                    $quantity = $request->input('visual-placement-quantity-'.$matches[1]);
                    $sale = $request->input('visual-placement-sale-'.$matches[1]);
                    $cost = $price * $quantity;
                    $surfaces[] = array(
                        'order_id' => $orderId,
                        'sorting_order' => $matches[1],
//                        'date_begin' => Helpers::convertDate($request->input('visual-placement-date-begin-'.$matches[1])),
//                        'date_end' => Helpers::convertDate($request->input('visual-placement-date-end-'.$matches[1])),
                        'date_begin' => $request->input('visual-placement-date-begin-'.$matches[1]),
                        'date_end' => $request->input('visual-placement-date-end-'.$matches[1]),
                        'location' => $request->input('visual-placement-location-'.$matches[1]),
                        'adv_place' => $request->input('visual-placement-vendor-'.$matches[1]),
                        'quantity' => $quantity,
                        'price' => $price,
                        'cost' => $cost,
                        'sale' => $sale,
                        'total_price' => Helpers::percentage($cost, $sale),
                        'paid' => $request->input('visual-placement-paid-'.$matches[1]),
                        'created_at' => Carbon::now()
                    );
                }
            }
        }

        if ($update) PlacementSurface::whereOrderId($orderId)->delete();

        if( ! empty($surfaces) && count($surfaces)){
            PlacementSurface::insert($surfaces);
            $result = count($surfaces);
        }

        return $result;
    }

}
