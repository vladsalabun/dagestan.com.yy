<?php

use App\Http\Controllers\OptionsController;
use Illuminate\Http\Request;


/**
 *      Родительские категории объявлений:
 */
Route::get('/get_root_categories', function (Request $request) {

    $array = array(
        'status' => 200,
    );
    
    $categories = DB::table('ads_categories')->where('parent_id',0)->get();
    
    if ($categories != null) {
        
        $array['items'] = array();
        
        foreach ($categories as $key => $value) {
            $array['items'][$key] = $value;
        }
    } else {
        $array = array('status' => 404, 'error' => 'Нет категорий.');
    }
    
    return response()->json($array);
    
});

/**
 *      Подкатегории:
 */
Route::get('/get_sub_categories', function (Request $request) {

    $array = array(
        'status' => 200,
    );

    $categories = DB::table('ads_categories')->where('parent_id',$request->id)->get();
    
    if($request->id < 1) {
        $array = array('status' => 404, 'error' => 'Не указан идентификатор родительской категории.');
    } else {

        $array['items'] = array();
    
        if ($categories != null) {
            foreach ($categories as $key => $value) {
                $array['items'][$key] = $value;
            }
        } else {
            $array = array('status' => 404, 'error' => 'Нет категорий.');
        }
    }
    
    return response()->json($array);
    
});


/**
 *      Города:
 */
Route::get('/get_towns', function (Request $request) {

    $array = array(
        'status' => 200,
    );
    
    $towns = DB::table('towns')->get();
    
    if ($towns != null) {
        
        $array['items'] = array();
        
        foreach ($towns as $key => $value) {
            $array['items'][$key] = $value;
        }
        
    } else {
        $array = array('status' => 404, 'error' => 'Нет городов.');
    }
    
    return response()->json($array);
    
});