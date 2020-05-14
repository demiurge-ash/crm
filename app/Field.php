<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    public static function orders($current)
    {
        if (empty($current->orderType)) return false;

        $orderFieldName = str_replace('visual-', '', $current->orderType);

        return Field::whereIn('type_order', ['main', $orderFieldName])->orderBy('type_set', 'asc')->get();
    }
}
