<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pavilion extends Model
{
    protected $perPage = 50;

    public function paint()
    {
        return $this->hasOne('App\Color', 'id','color');
    }
}
