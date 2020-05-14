<?php

namespace App\Http\Controllers;

use App\Helpers\File;
use App\Helpers\Helpers;
use App\Helpers\Response;
use App\Http\Requests\RadioForm;
use App\Order;
use App\RadioOrder;

class RadioOrderController extends Controller
{
    public function store(RadioForm $request)
    {
        OrderController::validateHeader($request);

        $new = Order::editOrNew($request, RadioOrder::class);

        $new = OrderController::storeMainFields($request, $new);

        $new->periods = $request->input('radio-periods');

        $new->date_begin = Helpers::convertDate($request->input('radio-date-begin'));
        $new->date_end = Helpers::convertDate($request->input('radio-date-end'));
        $new->quantity = $request->input('radio-quantity');
        $new->duration = $request->input('radio-duration');
        $new->price = $request->input('radio-price');
        $new->sale = $request->input('radio-sale');
        $new->paid = $request->input('radio-placement-paid');
        $new->text = $request->input('radio-text');

        $new->file = File::store( $request->file('radio-file'), 'radio' );

        $new->cost = $new->price;
        $new->total_price = Helpers::percentage($new->price, $new->sale);

        // EDIT or NEW ?
        if ( ! $new->order_id) $new->order_id = OrderController::new('radio');

        $new->save();

        return Response::jsonSuccessIdOrError($new->order_id);
    }

}
