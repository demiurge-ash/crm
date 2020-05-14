<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use TCG\Voyager\Traits\VoyagerUser;

class User extends \TCG\Voyager\Models\User
{
    use Notifiable;
    use VoyagerUser;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email',
        'email_verified_at',
        'created_at',
        'updated_at'
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function isOnlyBoss()
    {
        $roles = [
            'admin',
            'supermanager'
        ];
        if ( $this->hasRole( $roles ) ) {
            return true;
        }
        return false;
    }

    public function isBoss()
    {
        $roles = [
            'admin',
            'editor',
            'supermanager'
        ];
        if ( $this->hasRole( $roles ) ) {
            return true;
        }
        return false;
    }

    public function isDesigner()
    {
        $roles = [
            'designer'
        ];
        if ( $this->hasRole( $roles ) ) {
            return true;
        }
        return false;
    }

    public function isManager()
    {
        $roles = [
            'manager',
            'admin',
            'editor',
            'supermanager'
        ];
        if ( $this->hasRole( $roles ) ) {
            return true;
        }
        return false;
    }

    // check rights for view specific order
    public function canViewOrder($order)
    {
        if ( ! ( $this->isBoss() ) &&
            $this->id != $order->manager &&
            $this->id != $order->add_manager &&
            $this->id != $order->designer
        ) return false;

        return true;
    }

}
