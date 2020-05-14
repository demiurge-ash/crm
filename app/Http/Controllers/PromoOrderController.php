<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Helpers\Response;
use App\Http\Requests\PromoRequest;
use App\Order;
use App\OrderPromoter;
use App\PromoOrder;

class PromoOrderController extends Controller
{
    public function store(PromoRequest $request)
    {
        OrderController::validateHeader($request);

        $new = Order::editOrNew($request, PromoOrder::class);

        $new = OrderController::storeMainFields($request, $new);
        $new->date_payment = Helpers::convertDate($request->input('promo-date-payment'));
        $new->period = $request->input('promo-quantity-payment');
        $new->cost = $request->input('promo-cost-payment');
        $new->paid = $request->input('promo-paid');
        $new->company = $request->input('promo-company');
        $new->date_begin = Helpers::convertDate($request->input('promo-company-date-begin'));
        $new->date_end = Helpers::convertDate($request->input('promo-company-date-end'));
        $new->total_price = $new->cost;

        // EDIT or NEW ?
        $update = true;
        if ( ! $new->order_id) {
            $new->order_id = OrderController::new('promo');
            $update = false;
        }

        $promoters = OrderPromoter::getFromForm($request, $new->order_id, $update);
        $new->promoters = $promoters;

        $new->save();

        return Response::jsonSuccessIdOrError($new->order_id);
    }
}
