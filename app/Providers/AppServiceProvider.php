<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // polymorphic relationship for Orders
        Relation::morphMap([
            'visual-design' => 'App\DesignOrder',
            'visual-production' => 'App\ProductionOrder',
            'visual-placement' => 'App\PlacementOrder',
            'visual-montage' => 'App\MontageOrder',
            'photo' => 'App\PhotoOrder',
            'promo' => 'App\PromoOrder',
            'radio' => 'App\RadioOrder',
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
