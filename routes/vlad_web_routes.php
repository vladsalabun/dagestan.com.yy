<?php

/*
|--------------------------------------------------------------------------
| FRONTEND:
|--------------------------------------------------------------------------
*/

Route::get('/', 'FrontController@index');
Route::get('/404', 'FrontController@error404');

// Объявления:
Route::get('/ad/{id}', 'FrontController@ad_page');

Route::get('/company', 'FrontController@company_page');
Route::get('/page/{slug}', 'FrontController@page_page');



Route::group(['middleware' => ['auth']], function() {

    // Кабинет пользователя:
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/home/edit', 'HomeController@edit')->name('home');
        Route::post('/home', 'HomeController@changePassword');
    // Объявления:  
    Route::get('/add_ad', 'FrontController@add_ad');
    Route::get('/edit_ad/{id}', 'FrontController@edit_ad');
        Route::post('/post_add_ad', 'FrontController@post_add_ad');
        Route::post('/post_edit_ad', 'FrontController@post_edit_ad');
    Route::get('/success', 'FrontController@success_add_ad');    
        

});



/*
|--------------------------------------------------------------------------
| BACKEND:
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['auth','checkAdmin']], function () {
    
    Route::group(['prefix' => 'cp'], function () {
        
        // TODO: защитить админку паролем!
        Route::get('/', 'AdminMainController@index');
        Route::get('/banners', 'AdminMainController@banners');
        
        // Карта:
        Route::get('/map_config', 'MapController@map_config_page');
        Route::post('/post_edit_map_config', 'MapController@post_edit_map_config');
        
        // Объявления:
        Route::get('/ads', 'AdsController@ads');
        Route::get('/edit_ads/{id}', 'AdsController@edit_ads');
           Route::post('/post_edit_ads', 'AdsController@post_edit_ads');
        Route::get('/add_ads', 'AdsController@add_ads');
           Route::post('/post_add_ads', 'AdsController@post_add_ads');
        
        // Категории объявлений:
        Route::get('/adscategories', 'AdsCategoriesController@adscategories');
        Route::get('/edit_adscategories/{id}', 'AdsCategoriesController@edit_adscategories');
           Route::post('/post_edit_adscategories', 'AdsCategoriesController@post_edit_adscategories');
        Route::get('/add_adscategories', 'AdsCategoriesController@add_adscategories');
           Route::post('/post_add_adscategories', 'AdsCategoriesController@post_add_adscategories');

        // Города:
        Route::get('/towns', 'TownsController@towns');
        Route::get('/edit_town/{id}', 'TownsController@edit_town');
           Route::post('/post_edit_town', 'TownsController@post_edit_town');
        Route::get('/add_town', 'TownsController@add_town');
           Route::post('/post_add_town', 'TownsController@post_add_town');
        
        // Статичные страницы:
        Route::get('/pages', 'PagesController@index');
        Route::get('/add_page', 'PagesController@add_page');
            Route::post('/post_add_page', 'PagesController@post_add_page');
        Route::get('/edit_page/{id}', 'PagesController@edit_page');
            Route::post('/post_edit_page', 'PagesController@post_edit_page');
        
        // Пользователи:
        Route::get('/users', 'UsersController@users');
        Route::get('/edit_users/{id}', 'UsersController@edit_users');
           Route::post('/post_edit_users', 'UsersController@post_edit_users');
        Route::get('/add_users', 'UsersController@add_users');
           Route::post('/post_add_users', 'UsersController@post_add_users');
        
        // Баннеры:
        Route::get('/banners', 'BannersController@banners');
        Route::get('/edit_banners/{id}', 'BannersController@edit_banners');
           Route::post('/post_edit_banners', 'BannersController@post_edit_banners');
        Route::get('/add_banners', 'BannersController@add_banners');
           Route::post('/post_add_banners', 'BannersController@post_add_banners');

    });
    
});