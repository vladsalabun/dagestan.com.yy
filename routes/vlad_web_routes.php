<?php

/*
|--------------------------------------------------------------------------
| FRONTEND:
|--------------------------------------------------------------------------
*/

Route::get('/', 'FrontController@index');

Route::get('/add_ad', 'FrontController@add_ad');
Route::post('/post_add_ad', 'FrontController@post_add_ad');

Route::get('/ad/{id}', 'FrontController@ad_page');
Route::get('/company', 'FrontController@company_page');


Route::get('/home', 'HomeController@index')->name('home');





/*
|--------------------------------------------------------------------------
| BACKEND:
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'cp'], function () {
    
    Route::get('/', 'AdminMainController@index');
    Route::get('/banners', 'AdminMainController@banners');
    Route::get('/ads_categories', 'AdminMainController@ads_categories');
    Route::get('/ads', 'AdminMainController@ads');
    Route::get('/towns', 'AdminMainController@towns');
    
});