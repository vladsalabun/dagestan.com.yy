<?php

/*
|--------------------------------------------------------------------------
| FRONTEND:
|--------------------------------------------------------------------------
*/

Route::get('/', 'FrontController@index');
Route::get('/add_company', 'FrontController@add_company');
Route::get('/add_expert', 'FrontController@add_expert');
Route::get('/company/{id}', 'FrontController@company_page');
Route::get('/expert/{id}', 'FrontController@expert_page');


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