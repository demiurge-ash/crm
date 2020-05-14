<?php

namespace App\Http\Controllers;

use App\MontageOrder;
use App\MontageSurface;
use App\Order;

class MontageOrderController extends Controller
{
    public static function store($request)
    {
        $new = Order::editOrNew($request, MontageOrder::class);

        $new = OrderController::storeMainFields($request, $new);
        $new = OrderController::storeVisualFields($request, $new);

        // EDIT or NEW ?
        $update = true;
        if (!$new->order_id) {
            $new->order_id = OrderController::new('visual-montage');
            $update = false;
        }

        $surfaces = MontageSurface::getFromForm($request, $new->order_id, $update);

        $new->confirmed = MontageSurface::$orderDone;
//        $new->confirmed = $request->input('visual-montage-confirmed');

        $new->surfaces = $surfaces;

        $new->save();

        return $new->order_id;
    }
}
