<?php

use App\Http\Controllers\OptionsController;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Pages;
use App\Banners;
use App\Ads;
use App\Towns;
use App\AdsCategories;


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
        
        $array['status'] = 200;
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


/**
 *      get_all_ads_markers:
 */
Route::get('/get_all_ads_markers', function (Request $request) {
    
    $items = Ads::all();
 
    if ($items != null) {
        
        $array['status'] = 200;
        $array['items'] = array();
        
        foreach ($items as $key => $value) {
            
            if ($value->img == null) {
                $img_src = URL::to('/') . '/img/no-image-icon.png';
            } else {
                $img_src = URL::to('/') . '/storage/' . $value->img;
            }
            
            $array['items'][$key] = array(
                'id' => $value->id,
                'title' => $value->title,
                'img' => $img_src,
                'latitude' => $value->latitude,
                'longitude' => $value->longitude,
            );
        }
        
    } else {
        $array = array('status' => 404, 'error' => 'Нет баннеров.');
    }
    
    
    return response()->json($array);
});


/**
 *      Показать еще рекомендации:
 */
Route::get('/get_recommendations', function (Request $request) {

    $type = Input::get('type');
    $towns = Towns::all();
    $favourite_town = Cookie::get('favourite_town');
    
    if($favourite_town == null) {
        $favourite_town = $towns[0]->id;
    }

    $array = array(
        'status' => 200,
    );
    
    if($type > 0) {
        $ads = Ads::where('town_id',$favourite_town)->where('type', $type)->where('moderation', 1)->orderBy('date','desc')->paginate(6);
    } else {
        $ads = Ads::where('town_id',$favourite_town)->where('moderation', 1)->orderBy('date','desc')->paginate(6);
    }
    
    if ($ads != null) {
        
        if(count($ads) > 0) {
        
            foreach ($ads as $key => $value) {
                
                if ($value->img == null) {
                    $img_src = URL::to('/') . '/img/no-image.png';
                } else {
                    $img_src = URL::to('/') . '/storage/' . $value->img;
                }
                
                $array['items'][$key] = array(
                    'id' => $value->id,
                    'title' => $value->title,
                    'description' => Str::limit($value->description),
                    'img' => $img_src,
                    'address' => $value->address,
                    'stars' => $value->stars,
                );
            }
        
        } else {
            $array = array('status' => 404, 'error' => 'Нет рекомендаций.');
        }
    } else {
        $array = array('status' => 404, 'error' => 'Нет рекомендаций.');
    }

    return response()->json($array);
    
});


/**
 *      Показать еще объявления:
 */
Route::get('/get_more', function (Request $request) {

        $array = array(
            'status' => 200,
        );
        
        $towns = Towns::all();
        
        // Узнаю город для рекомендаций:
        $favourite_town = Cookie::get('favourite_town');
        if($favourite_town == null) {
            $favourite_town = $towns[0]->id;
        }
        
        if(isset($request->filter)) {
            

            
            /* ПОШУК: */
            $paginate = 6;
            
            if( $request->filter == 'organizations') {
                $type = 1;
            } else if( $request->filter == 'specialists') {
                $type = 2;
            } else {
                $type = 0;
            }
            
             // Беру объявлений города:
            if($type > 0) {
                $ads = Ads::where('town_id',$favourite_town)->where('type', $type)->where('moderation', 1)->orderBy('date','desc')->paginate($paginate);
            } else {
                $ads = Ads::where('town_id',$favourite_town)->where('moderation', 1)->orderBy('date','desc')->paginate($paginate);
            }
            
            if ($ads != null) {
                
                if(count($ads) > 0) {
                
                    foreach ($ads as $key => $value) {
                        
                        if ($value->img == null) {
                            $img_src = URL::to('/') . '/img/no-image.png';
                        } else {
                            $img_src = URL::to('/') . '/storage/' . $value->img;
                        }
                        
                        $array['items'][$key] = array(
                            'id' => $value->id,
                            'title' => $value->title,
                            'description' => Str::limit($value->description),
                            'img' => $img_src,
                            'address' => $value->address,
                            'stars' => $value->stars,
                        );
                    }
                
                } else {
                    $array = array('status' => 404, 'error' => 'Нет объявлений.');
                }
            } else {
                $array = array('status' => 404, 'error' => 'Нет объявлений.');
            }
            
            
        } else {

            
            /* ПОШУК: */
            $paginate = 6;
            
            $input = Input::all();
            $categories_ids = explode(',',Input::get('categories_ids'));
            $search_text = Input::get('search');

            
            if(count($categories_ids) == 1) {
                if($categories_ids[0] >= 1) {
                    $parent_category_to_expand = (new AdsCategories)->get_parent_name($categories_ids[0]);
                } else {
                    $parent_category_to_expand = 0;
                }
            } else {
                $parent_category_to_expand = 0;
            }

            $sort = array(
                'asc', 'desc'
            );
            
            // Беру промодерированные объявления:
            $ads = Ads::where('moderation', 1);
            
            // Ищу по заголовкам, если указана строка поиска:
            if(Input::get('search') != null) {
                $ads->where('title', 'like', '%' . Input::get('search') . '%');
            }
            
            // Ищу по связям с категориями:
            if(Input::get('categories_ids') != null) {
                $ads->whereHas('categories', function ($query) use ($categories_ids) {
                    $query->whereIn('category_id', $categories_ids);
                });
            }
            
            // Ищу вилку цен:
            if(Input::get('price_from') != null and Input::get('price_to') != null) {
                $ads->where('average_price', '>', Input::get('price_from'))->where('average_price', '<', Input::get('price_to'));
                
            } else if (Input::get('price_from') != null and Input::get('price_to') == null) {
                
                // Ищу цену начиная с минимального значения:
                $ads->where('average_price', '>', Input::get('price_from'));
                
            } else if (Input::get('price_from') == null and Input::get('price_to') != null) {
                
                // Ищу цену до максимального значения:
                $ads->where('average_price', '<', Input::get('price_to'));
                
            } else {
                
            }

            // Сортирую по типу:
            if(Input::get('type') != null) {
                if(Input::get('type') == 1) { 
                    $ads->orderBy('type', 'asc');
                    
                }
                if(Input::get('type') == 2) { 
                    $ads->orderBy('type', 'desc');
                    
                }
            }
            
            // Сортирую по дате:
            if(Input::get('sort_date') != null) {
                if(in_array(Input::get('sort_date'), $sort)) { 
                    $ads->orderBy('date', Input::get('sort_date'));
                }
            }
            
            // Сортирую по стоимости:
            if(Input::get('sort_price') != null) {
                if(in_array(Input::get('sort_price'), $sort)) { 
                    $ads->orderBy('average_price', Input::get('sort_price'));
                }
            }
            

            $ads = $ads->paginate($paginate);

            if ($ads != null) {
                
                if(count($ads) > 0) {
                
                    foreach ($ads as $key => $value) {
                        
                        if ($value->img == null) {
                            $img_src = URL::to('/') . '/img/no-image.png';
                        } else {
                            $img_src = URL::to('/') . '/storage/' . $value->img;
                        }
                        
                        $array['items'][$key] = array(
                            'id' => $value->id,
                            'title' => $value->title,
                            'description' => Str::limit($value->description),
                            'img' => $img_src,
                            'address' => $value->address,
                            'stars' => $value->stars,
                        );
                    }
                
                } else {
                    $array = array('status' => 404, 'error' => 'Нет объявлений.');
                }
            } else {
                $array = array('status' => 404, 'error' => 'Нет объявлений.');
            }
        
        }

        return response()->json($array);
    
});
