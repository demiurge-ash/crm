<?php

namespace App\Helpers;

class Response
{
    public static function jsonSuccessIdOrError($orderId)
    {
        if ( ! $orderId)
            return response()->json([ 'errors' => ['Ни одна форма не заполнена'] ], 404);

        return response()->json([
            'result' => 'success',
            'id' => $orderId
        ]);
    }
}