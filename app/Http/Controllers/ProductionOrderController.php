<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Order;
use App\ProductionOrder;

class ProductionOrderController extends Controller
{
    public static function store($request)
    {
        $new = Order::editOrNew($request, ProductionOrder::class);

        $new = OrderController::storeMainFields($request, $new);
        $new = OrderController::storeVisualFields($request, $new);

        $new->contractor = $request->input('visual-production-contractor');
        $new->quantity = $request->input('visual-production-quantity');
        $new->contractor_price = $request->input('visual-production-contractor-price');
        $new->price = $request->input('visual-production-price');
        $new->cost = $new->quantity * $new->price;
        $new->sale = $request->input('visual-production-sale');
        $new->total_price = Helpers::percentage($new->cost, $new->sale);
        $new->paid = $request->input('visual-production-paid');
        $new->text = $request->input('visual-production-materials');

        $new->width = $request->input('visual-design-width');
        $new->height = $request->input('visual-design-height');
        $new->area = $new->width * $new->height;
        $new->side = $request->input('visual-production-side');
        $new->direction = $request->input('visual-production-direction');
        $new->confirmed = $request->input('visual-production-confirmed');

        // EDIT or NEW ?
        if (!$new->order_id) $new->order_id = OrderController::new('visual-production');

        $new->save();

        return $new->order_id;
    }
}
