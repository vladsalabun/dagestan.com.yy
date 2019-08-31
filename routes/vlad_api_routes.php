<?php

use App\Http\Controllers\OptionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Pages;
use App\Banners;

// TODO: get_companies_markers


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

/**
 *      Проверка слага:
 */
Route::get('/check_slug', function (Request $request) {
    
    // Создаю слаг:
    $slug = Str::slug($request->slug, '-');
        
    // Проверяю есть ли в базе данных такой слаг:
    $check_slug = Pages::where('slug', $slug)->first();
    
    // Если дубль, изменяю слаг:
    if($check_slug != null) {
        $array = array(
            'status' => 404
        );
    } else {
        $array = array(
            'status' => 200,
            'slug' => $slug,
        );
    }
    
    return response()->json($array);
    
});

/**
 *      Баннеры на фронт:
 */
Route::get('/get_banners', function (Request $request) {
    

    $items = Banners::all();

    if ($items != null) {
        
        $array['items'] = array();
        
        foreach ($items as $key => $value) {
            
            if ($value->img == null) {
                $img_src = URL::to('/') . '/img/no-image-icon.png';
            } else {
                $img_src = URL::to('/') . '/storage/' . $value->img;
            }
            
            $array['items'][$key] = array(
                'title' => $value->title,
                'img' => $img_src,
            );
        }
        
    } else {
        $array = array('status' => 404, 'error' => 'Нет баннеров.');
    }
    
    return response()->json($array);
    
});
