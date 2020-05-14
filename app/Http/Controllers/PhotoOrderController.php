<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Helpers\Response;
use App\Http\Requests\PhotoRequest;
use App\Order;
use App\OrderPhotographer;
use App\PhotoOrder;

class PhotoOrderController extends Controller
{
    public function store(PhotoRequest $request)
    {
        OrderController::validateHeader($request);

        $new = Order::editOrNew($request, PhotoOrder::class);

        $new = OrderController::storeMainFields($request, $new);

        $new->date_payment = Helpers::convertDate($request->input('photo-date-payment'));
        $new->period = $request->input('photo-period');
        $new->cost = $request->input('photo-cost');
        $new->paid = $request->input('photo-paid');
        $new->company = $request->input('photo-company');
        $new->date_begin = Helpers::convertDate($request->input('photo-company-date-begin'));
        $new->date_end = Helpers::convertDate($request->input('photo-company-date-end'));
        $new->total_price = $new->cost;

        // EDIT or NEW ?
        $update = true;
        if ( ! $new->order_id) {
            $new->order_id = OrderController::new('photo');
            $update = false;
        }

        $photographers = OrderPhotographer::getFromForm($request, $new->order_id, $update);
        $new->photographers = $photographers;

        $new->save();

        return Response::jsonSuccessIdOrError($new->order_id);
    }

}
