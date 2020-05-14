<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DesignOrder extends Model
{
    public static $sides = [
        0 => 'Односторонний',
        1 => 'Двусторонний',
    ];
    public static $directions = [
        0 => 'Вертикальный',
        1 => 'Горизонтальный'
    ];

    public function manager()
    {
        return $this->hasOne(User::class,'id','manager');
    }

    public function suborders()
    {
        return $this->morphMany('App\Order', 'orderable');
    }

    public static function getSize($order)
    {
        if ($order->orderType != 'visual-design') return false;

        $side = self::$sides[$order->side];
        $direction = self::$directions[$order->direction];

        return $side . '-' . $direction;
    }
}
