<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worktime extends Model
{
    protected $fillable = [
        'user_id',
        'direction',
        'time',
        'day'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
