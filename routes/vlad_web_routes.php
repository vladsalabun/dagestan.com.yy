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
    
    // Карта:
    Route::get('/map_config', 'MapController@map_config_page');
    Route::post('/post_edit_map_config', 'MapController@post_edit_map_config');
    
    // Категории объявлений:
    Route::get('/adscategories', 'AdsCategoriesController@adscategories');
    Route::get('/edit_adscategories/{id}', 'AdsCategoriesController@edit_adscategories');
       Route::post('/post_edit_adscategories', 'AdsCategoriesController@post_edit_adscategories');
    Route::get('/add_adscategories', 'AdsCategoriesController@add_adscategories');
       Route::post('/post_add_adscategories', 'AdsCategoriesController@post_add_adscategories');
    
    // Объявления:
    Route::get('/ads', 'AdminMainController@ads');

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
    
    
    
    
});