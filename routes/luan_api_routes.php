<?php

//Luan code
Route::get('/notifications', 'Api\UserController@listNotification');
Route::post('user/login', 'Api\UserController@login');
Route::post('user/register', 'Api\UserController@register');
Route::post('user/sell_apartment', 'Api\UserController@sellApartment');
Route::post('user/water_delivery', 'Api\UserController@waterDelivery');
Route::post('user/rent_apartment', 'Api\UserController@rentApartment');
Route::post('user/upload_photo_sell', 'Api\UserController@uploadPhotoSell');
Route::post('user/upload_photo_rent', 'Api\UserController@uploadPhotoRent');
Route::post('user/getuser', 'Api\UserController@getUser');
Route::post('ads/upload_photo_add', 'Api\AdsController@uploadPhotoAdd');
Route::post('ads/upload_photo_edit', 'Api\AdsController@uploadPhotoEdit');
Route::group(['middleware' => ['auth:api']], function () {
    Route::post('/user/update', 'Api\UserController@update');
    Route::post('/user/update_pwd', 'Api\UserController@updatePwd');
    Route::post('/user/update_avatar', 'Api\UserController@updateAvatar');
    Route::get('/chatgroups', 'Api\ChatGroupController@chatgroups');
    Route::get('/chatgroups/chatgroup/{id}', 'Api\ChatGroupController@chatgroup');
    Route::get('/messages', 'Api\MessageController@messages');
    Route::get('/messages/message/{id}', 'Api\MessageController@message');
    Route::post('/messages/message', 'Api\MessageController@insert');

    Route::get('/ads/ad', 'Api\AdsController@ad');
    Route::post('/ads/report', 'Api\AdsController@report');
    Route::post('/ads/add', 'Api\AdsController@add');
    Route::post('/ads/edit', 'Api\AdsController@edit');
    Route::get('/ads/delete', 'Api\AdsController@delete');
});
Route::get('ads/revcats', 'Api\AdsController@getRevCategories');
Route::get('/ads/categories_two', 'Api\AdsController@categoriesTwo');
// Vlad: These methods must be accessible without auth:
Route::get('/ads', 'Api\AdsController@ads');
Route::get('/ads/categories', 'Api\AdsController@categories');