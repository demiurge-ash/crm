<?php

namespace App\Http\Controllers;

use App\DesignOrder;
use App\Helpers\Helpers;
use App\Order;

class DesignOrderController extends Controller
{
    public static function store($request)
    {
        $new = Order::editOrNew($request, DesignOrder::class);

        $new = OrderController::storeMainFields($request, $new);
        $new = OrderController::storeVisualFields($request, $new);

        $new->date_payment = Helpers::convertDate($request->input('visual-design-date-payment'));

        $new->width = $request->input('visual-design-width');
        $new->height = $request->input('visual-design-height');
        $new->area = $new->width * $new->height;

        $new->side = $request->input('visual-design-side');
        $new->direction = $request->input('visual-design-direction');
        $new->total_price = $request->input('visual-design-total-price');
        $new->paid = $request->input('visual-design-paid');
        $new->confirmed = $request->input('visual-design-confirmed');
        $new->text = $request->input('visual-design-task');
        $new->edits = $request->input('visual-design-edits');

        if (!empty($request->file('visual-design-file')))
            $new->file = $request->file('visual-design-file')->store('design');

        // EDIT or NEW ?
        if (!$new->order_id) $new->order_id = OrderController::new('visual-design');

        $new->save();

        return $new->order_id;
    }
}
