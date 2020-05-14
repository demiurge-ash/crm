<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeSchedule extends Model
{
    protected $fillable = [
        'user_id',
        'time_begin',
        'time_end',
        'date'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
