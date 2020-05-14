<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhotoOrder extends Model
{
    public function suborders()
    {
        return $this->morphMany('App\Order', 'orderable');
    }
}
