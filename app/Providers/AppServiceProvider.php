<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        //
        Schema::defaultStringLength(191);
        
        //
        $favourite_town = Cookie::get('favourite_town');
        if($favourite_town == null) {
            $favourite_town = 1;
        }
        view()->share('favourite_town', $favourite_town);
        
    }
}
