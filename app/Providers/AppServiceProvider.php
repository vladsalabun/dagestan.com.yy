<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use App\AdsCategories;
use Illuminate\Support\Facades\Input;

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
        
        // 
        $all_categories = AdsCategories::orderBy('name', 'asc')->get();
        view()->share('all_categories', $all_categories);
        
        view()->share('search_text', Input::get('search'));
        
         $categories_ids_array = array();
        
        if (Input::has('categories_ids')) {
            view()->share('categories_ids', Input::get('categories_ids'));
            
            if(strlen(Input::get('categories_ids') > 0)) {
                $categories_ids_array = explode(',', Input::get('categories_ids'));
            }            
            view()->share('categories_ids_array', $categories_ids_array);
        } else {
            view()->share('categories_ids', '');
            view()->share('categories_ids_array', $categories_ids_array);
        }
        
    }
}
