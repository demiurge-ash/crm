<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public $fillable = [
        'name',
        'phone',
        'email',
        'description',
    ];

    public static function prepareClient($new)
    {
        $client = Client::firstOrCreate(
            ['name' => $new->client_name],
            ['phone' => $new->client_phone, 'email' => $new->client_email]
        );
        return $client;
    }
}
