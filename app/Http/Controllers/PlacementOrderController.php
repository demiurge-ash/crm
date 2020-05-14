<?php

namespace App\Http\Controllers;

use App\Order;
use App\PlacementOrder;
use App\PlacementSurface;

class PlacementOrderController extends Controller
{
    public static function store($request)
    {
        $new = Order::editOrNew($request, PlacementOrder::class);

        $new = OrderController::storeMainFields($request, $new);
        $new = OrderController::storeVisualFields($request, $new);

        $new->confirmed = $request->input('visual-placement-confirmed');

        // EDIT or NEW ?
        $update = true;
        if (!$new->order_id) {
            $new->order_id = OrderController::new('visual-placement');
            $update = false;
        }

        $surfaces = PlacementSurface::getFromForm($request, $new->order_id, $update);
        $new->surfaces = $surfaces;

        $new->save();

        return $new->order_id;
    }
}
