<?php

namespace App\Http\Controllers;

use App\DesignOrder;
use App\Helpers\Response;
use App\Http\Requests\DesignerFileRequest;
use App\Http\Requests\VisualRequest;
use App\MontageSurface;

class VisualOrderController extends Controller
{
    public function store(VisualRequest $request)
    {
        OrderController::validateHeader($request);

        $orderId = [];

        if ( $request->input('visual-design-total-price') > 0 )
            $orderId[] = DesignOrderController::store($request);

        if ( $request->input('visual-production-total-price') > 0 )
            $orderId[] = ProductionOrderController::store($request);

        if ( $request->input('visual-placement-total-price-1') > 0 )
            $orderId[] = PlacementOrderController::store($request);

        if ( MontageSurface::checkTotalPrice($request) > 0 )
            $orderId[] = MontageOrderController::store($request);

        return Response::jsonSuccessIdOrError($orderId);
    }

    public function designerFile(DesignerFileRequest $request)
    {
        $designer_file = $request->file('designer_file')->store('design');

        DesignOrder::whereOrderId($request->order_id)->update([ 'designer_file' => $designer_file ]);

        return redirect('/order/show/' . $request->order_id );
    }

}
