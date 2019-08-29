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

});



/*
|--------------------------------------------------------------------------
| BACKEND:
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'cp'], function () {
    
    // TODO: защитить админку паролем!
    Route::get('/', 'AdminMainController@index');
    Route::get('/banners', 'AdminMainController@banners');
    Route::get('/ads_categories', 'AdminMainController@ads_categories');
    Route::get('/ads', 'AdminMainController@ads');
    Route::get('/towns', 'AdminMainController@towns');
    Route::get('/pages', 'PagesController@index');
    Route::get('/add_page', 'PagesController@add_page');
        Route::post('/post_add_page', 'PagesController@post_add_page');
    Route::get('/edit_page/{id}', 'PagesController@edit_page');
        Route::post('/post_edit_page', 'PagesController@post_edit_page');
    
});