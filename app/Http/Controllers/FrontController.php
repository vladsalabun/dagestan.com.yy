<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use URL;
use Storage;
use Auth;
use App\Pages;
use App\Ads;
use App\AdsCategories;
use App\Banners;
use App\Towns;
use App\Users;
use App\UserStars;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Input;

class FrontController extends Controller
{
    public function get_towns()
	{
        return Towns::all();
    }
    public function get_banners()
	{
        return Banners::all();
    }
    
    
    // Главная:
    public function index()
	{
        
        $towns = $this->get_towns();
        // Узнаю город для рекомендаций:
        $favourite_town = Cookie::get('favourite_town');
        if($favourite_town == null) {
            $favourite_town = $towns[0]->id;
        }
        
        
        $filter = Input::get('filter');
        if( $filter == 'organizations') {
            $type = 1;
        } else if( $filter == 'specialists') {
            $type = 2;
        } else {
            $type = 0;
        }

        
        $banners = $this->get_banners();
        
        // Беру объявлений города:
        if($type > 0) {
            $ads = Ads::where('town_id',$favourite_town)->where('type', $type)->where('moderation', 1)->orderBy('date','desc')->paginate(6);
        } else {
            $ads = Ads::where('town_id',$favourite_town)->where('moderation', 1)->orderBy('date','desc')->paginate(6);
        }
        
        
        return view('front.index', compact('banners','towns','ads','type', 'filter'));
    }

    // 404:
    public function error404()
	{
        $towns = $this->get_towns();
        
        return view('front.404', compact('towns'));
    }
    public function on_moderation()
	{
        $towns = $this->get_towns();
        
        return view('front.on_moderation', compact('towns'));
    }
    
    
    // Страница объявления:
    public function ad_page($id)
	{
        $stars = UserStars::where('ad_id',$id)->get()->count();
        if (Auth::check()) {
            $current_user_star = UserStars::where('ad_id',$id)->where('user_id', Auth::user()->id)->first();
        } else {
            $current_user_star = 0;
        }
        
        $towns = $this->get_towns();
        $ad = Ads::where('id',$id)->first();
        if($ad == null) {
            return redirect(URL::to('/').'/404'); 
        }
        if($ad->moderation == 0) {
            return redirect(URL::to('/').'/on_moderation'); 
        }
        
        $google_map_key = OptionsController::get_option('google_map_key'); 

        if(count($google_map_key) == 0) {
            OptionsController::set_option('google_map_key', null);
            $google_map_key = null;
        } else {
            $google_map_key = $google_map_key[0]->option_value;
        }
        
        $openstreetmap_api_key = OptionsController::get_option('openstreetmap_api_key'); 

        if(count($openstreetmap_api_key) == 0) {
            OptionsController::set_option('openstreetmap_api_key', null);
            $openstreetmap_api_key = null;
        } else {
            $openstreetmap_api_key = $openstreetmap_api_key[0]->option_value;
        }
        
        // longitude
        $longitude = OptionsController::get_option('longitude'); 

        if(count($longitude) == 0) {
            OptionsController::set_option('longitude', null);
            $longitude = null;
        } else {
            $longitude = $longitude[0]->option_value;
        }
        
        // latitude
        $latitude = OptionsController::get_option('latitude'); 

        if(count($latitude) == 0) {
            OptionsController::set_option('latitude', null);
            $latitude = null;
        } else {
            $latitude = $latitude[0]->option_value;
        }
        
        $maxZoom = 18;
        $initZoom = 13;
        
        $max_center = array($longitude, $latitude);
        
        // TODO: хлібні крихти
        //dd($ad->categories);
        
        return view('front.ad_page', compact('id', 'towns','ad', 'google_map_key', 'latitude', 'longitude', 'openstreetmap_api_key','maxZoom','initZoom','max_center','stars','current_user_star'));
    }
    
    // Список специалистов:
    public function company_page()
	{
        $towns = $this->get_towns();
        
        $google_map_key = OptionsController::get_option('google_map_key'); 

        if(count($google_map_key) == 0) {
            OptionsController::set_option('google_map_key', null);
            $google_map_key = null;
        } else {
            $google_map_key = $google_map_key[0]->option_value;
        }
        
        $openstreetmap_api_key = OptionsController::get_option('openstreetmap_api_key'); 

        if(count($openstreetmap_api_key) == 0) {
            OptionsController::set_option('openstreetmap_api_key', null);
            $openstreetmap_api_key = null;
        } else {
            $openstreetmap_api_key = $openstreetmap_api_key[0]->option_value;
        }
        
        // Узнаю город для рекомендаций:
        $favourite_town = Cookie::get('favourite_town');
        if($favourite_town == null) {
            $favourite_town = $towns[0]->id;
        }
        
        $favourite_town_info = Towns::where('id',$favourite_town)->first();
        if($favourite_town_info->longitude == null or $favourite_town_info->latitude == null) {
            // longitude
            $longitude = OptionsController::get_option('latitude'); 

            if(count($longitude) == 0) {
                OptionsController::set_option('latitude', null);
                $longitude = null;
            } else {
                $longitude = $longitude[0]->option_value;
            }
            
            // latitude
            $latitude = OptionsController::get_option('longitude'); 

            if(count($latitude) == 0) {
                OptionsController::set_option('longitude', null);
                $latitude = null;
            } else {
                $latitude = $latitude[0]->option_value;
            }
        } else {
            $longitude = $favourite_town_info->longitude;
            $latitude = $favourite_town_info->latitude;
        }
        
        $maxZoom = 18;
        $initZoom = 12;
        
        $max_center = array($longitude, $latitude);
        
        $categories_ids = explode(',',Input::get('categories_ids'));
        $categories_tree = (new AdsCategories)->get_tree();
        
            if(count($categories_ids) == 1) {
                if($categories_ids[0] >= 1) {
                    $parent_category_to_expand = (new AdsCategories)->get_parent_name($categories_ids[0]);
                } else {
                    $parent_category_to_expand = 0;
                }
            } else {
                $parent_category_to_expand = '';
            }

        
        $ads = $this->searchAds('paginated');
        $ads_full = $this->searchAds('full');

            $markers = array(); 
            
            foreach ($ads_full as $ad_tmp_id => $ad_tmp) {
                
                if($ad_tmp->longitude != null and $ad_tmp->latitude != null) {
                    $markers[$ad_tmp_id]['id'] = $ad_tmp->id;
                    $markers[$ad_tmp_id]['title'] = $ad_tmp->title;
                    $markers[$ad_tmp_id]['address'] = $ad_tmp->address;
                    $markers[$ad_tmp_id]['img'] = $ad_tmp->img;
                    $markers[$ad_tmp_id]['longitude'] = $ad_tmp->longitude;
                    $markers[$ad_tmp_id]['latitude'] = $ad_tmp->latitude;
                }
            }
/*
            $markers = array(); 
            
            foreach ($ads as $ad_tmp_id => $ad_tmp) {
                
                if($ad_tmp->longitude != null and $ad_tmp->latitude != null) {
                    $markers[$ad_tmp_id]['id'] = $ad_tmp->id;
                    $markers[$ad_tmp_id]['title'] = $ad_tmp->title;
                    $markers[$ad_tmp_id]['address'] = $ad_tmp->address;
                    $markers[$ad_tmp_id]['img'] = $ad_tmp->img;
                    $markers[$ad_tmp_id]['longitude'] = $ad_tmp->longitude;
                    $markers[$ad_tmp_id]['latitude'] = $ad_tmp->latitude;
                }
            }
*/
        
        

        
        //dd($markers);
        // TODO: save search query? text, cats, results_count, date
        
        return view('front.company_page', compact('categories_tree', 'towns', 'ad', 'google_map_key', 'latitude', 'longitude', 'openstreetmap_api_key','maxZoom','initZoom','max_center','search_text','parent_category_to_expand','ads','markers','filter'));
        
    }
    
    
    
    
    
    
    
    
    // Страница добавления объявления:
    public function add_ad()
	{
        $towns = $this->get_towns();

        if(Auth::user()->is_ban == 1) {
            return redirect('/home'); 
        }
        
        $google_map_key = OptionsController::get_option('google_map_key'); 

        if(count($google_map_key) == 0) {
            OptionsController::set_option('google_map_key', null);
            $google_map_key = null;
        } else {
            $google_map_key = $google_map_key[0]->option_value;
        }
        
        $openstreetmap_api_key = OptionsController::get_option('openstreetmap_api_key'); 

        if(count($openstreetmap_api_key) == 0) {
            OptionsController::set_option('openstreetmap_api_key', null);
            $openstreetmap_api_key = null;
        } else {
            $openstreetmap_api_key = $openstreetmap_api_key[0]->option_value;
        }
        
        // longitude
        $longitude = OptionsController::get_option('longitude'); 

        if(count($longitude) == 0) {
            OptionsController::set_option('longitude', null);
            $longitude = null;
        } else {
            $longitude = $longitude[0]->option_value;
        }
        
        // latitude
        $latitude = OptionsController::get_option('latitude'); 

        if(count($latitude) == 0) {
            OptionsController::set_option('latitude', null);
            $latitude = null;
        } else {
            $latitude = $latitude[0]->option_value;
        }
        
        $maxZoom = 18;
        $initZoom = 13;
        
        $max_center = array($longitude, $latitude);
        
        return view('front.add_ad', compact('towns', 'google_map_key', 'latitude', 'longitude', 'openstreetmap_api_key','maxZoom','initZoom','max_center'));
    }
   
    // Статичные страницы:
    public function page_page($slug)
	{
        $towns = $this->get_towns();
        
        $page = Pages::where('slug',$slug)->where('publish_status', 1)->first();
        if($page == null) {
            return redirect('/404'); 
        }
        return view('front.page', compact('page', 'towns'));
    }
   

    public function post_add_ad(Request $request)
	{        
           // Создать запись:
           $obj = new Ads;

           $obj->type = $request->type;
           $obj->user_id = Auth::user()->id;
           $obj->title = $request->title;
           $obj->description = $request->description;
           $obj->price = $request->price;
           $obj->address = $request->address;
           $obj->site = $request->site;
           $obj->email = $request->email;
           $obj->phone = $request->phone;
           $obj->vk = $request->vk;
           $obj->ok = $request->ok;
           $obj->instagram = $request->instagram;
           $obj->fb = $request->fb;
           $obj->longitude = $request->longitude;
           $obj->latitude = $request->latitude;           
           $obj->date = date('Y-m-d H:i:s');
           $obj->moderation = 0;
           $obj->name = $request->name;
           $obj->surname = $request->surname;
           $obj->town_id = $request->town_id;
           $obj->working_hours = $request->working_hours;
           $obj->work_expiriens = $request->work_expiriens;
           $obj->average_price = $request->average_price;
          
           $obj->save();  

                // Если загружен файл:
                if($request->hasFile('img')) {
                    
                    $uploadedFile = $request->file('img');
                    $banner_filename = time().'_'.$uploadedFile->getClientOriginalName();

                    Storage::disk('public')->putFileAs(
                        'photos/',
                        $uploadedFile,
                        $banner_filename
                    );
                    
                    // Обновляю banner:
                    Ads::where('id', $obj->id)
                    ->update(
                        array(
                            'img' => 'photos/'.$banner_filename, 
                        )
                    ); 
                    
                }
               
                if(isset($request->sub_category)) {
                    // Категории:
                    DB::table('ads_has_categories')->insertGetId(
                        array(
                            'ad_id' => $obj->id,
                            'category_id' => $request->sub_category,
                        )
                    );
                } 

        return redirect(URL::to('/').'/success'); 
        
    }
    
    public function success_add_ad() 
    {
        $towns = $this->get_towns();
        return view('front.success_add_ad', compact('towns'));
    }
    
    
    public function edit_ad($id)
	{
        $towns = $this->get_towns();
        
        
        // Ищу объявление:
        $ad = Ads::where('id',$id)->first();
        
        // Если не существует:
        if($ad == null) {
            if(Auth::check()) {
                return redirect(URL::to('/').'/home');
            } else {
                return redirect(URL::to('/').'/login');
            }
        }
        
        // Если это чужое объявление:
        if($ad->user_id != Auth::user()->id) {
            return redirect(URL::to('/').'/home');
        }
        
        return view('front.edit_ad', compact('ad', 'towns'));

    }
    public function post_edit_ad(Request $request)
	{
    
        // Ищу объявление:
        $obj = Ads::where('id',$request->id)->first();
        
        if(Auth::user()->id == $obj->user_id) {
            
           if(isset($request->delete)) {
               
               // Беру обєкт:
               $obj = Ads::where('id', $request->id)->first();
               // Видаляю зображення:
               if($obj->img != null) {
                    Storage::disk('public')->delete($obj->img);
               }
               // Видаляю категорії:
               DB::table('ads_has_categories')
                   ->where('ad_id',$obj->id)
                   ->delete();
               
               Ads::where('id', $request->id)->delete();
               return redirect(URL::to('/').'/home');
           }       // update ads 
           if(isset($request->submit)) {
            
           $obj->title = $request->title;
           $obj->town_id = $request->town;
           $obj->description = $request->description;
           $obj->price = $request->price;
           $obj->address = $request->address;
           $obj->site = $request->site;
           $obj->email = $request->email;
           $obj->phone = $request->phone;
           $obj->vk = $request->vk;
           $obj->ok = $request->ok;
           $obj->instagram = $request->instagram;
           $obj->fb = $request->fb;
           $obj->moderation = 0;
           $obj->name = $request->name;
           $obj->surname = $request->surname;
           $obj->working_hours = $request->working_hours;
           $obj->work_expiriens = $request->work_expiriens;
           $obj->average_price = $request->average_price;
      
           $obj->save();  

            // Если загружен файл:
            if($request->hasFile('img')) {
                
                $uploadedFile = $request->file('img');
                $banner_filename = time().'_'.$uploadedFile->getClientOriginalName();

                Storage::disk('public')->putFileAs(
                    'photos/',
                    $uploadedFile,
                    $banner_filename
                );
                
                // Обновляю banner:
                Ads::where('id', $obj->id)
                ->update(
                    array(
                        'img' => 'photos/'.$banner_filename, 
                    )
                ); 
                
            }
               
                
               
               
                if(isset($request->sub_category)) {
                    
                    DB::table('ads_has_categories')->where('ad_id',$obj->id)->delete();
                    
                    // Категории:
                    DB::table('ads_has_categories')->insertGetId(
                        array(
                            'ad_id' => $obj->id,
                            'category_id' => $request->sub_category,
                        )
                    );
                }
                
                return redirect(URL::to('/').'/success'); 
           
           }
        }
        
        return redirect('/404');

    }
    
    public function chacheTown($id, Request $request)
	{
        $cookie = Cookie::make('favourite_town', $id);
        
        return back()->cookie($cookie);
    }
    
    /*
        Пошук:
    */
    public function searchAds($return_count)
	{
        
        $towns = $this->get_towns();
        
        /* ПОШУК: */
        $paginate = 10;
        
        $categories_ids = explode(',',Input::get('categories_ids'));
        $search_text = Input::get('search');
        
        // Узнаю город для рекомендаций:
        $favourite_town = Cookie::get('favourite_town');
        if($favourite_town == null) {
            $favourite_town = $towns[0]->id;
        }
        
        $favourite_town_info = Towns::where('id',$favourite_town)->first();
        
        if($favourite_town_info->longitude != null and $favourite_town_info->latitude != null) {
            $max_center[0] = $favourite_town_info->latitude;
            $max_center[1] = $favourite_town_info->longitude;
        }
        
        $filter = Input::get('filter'); 
        if( $filter == 'organizations') {
            $type = 1;
        } else if( $filter == 'specialists') {
            $type = 2;
        } else {
            $type = 0;
        }
        
        $parent_category_to_expand = 0;
        
            $sort = array(
                'asc', 'desc'
            );
        
        if($type == 0) {


            // Беру промодерированные объявления:
            $ads = Ads::where('moderation', 1)->where('town_id',$favourite_town);
            $ads_full = Ads::where('moderation', 1)->where('town_id',$favourite_town);
            
            // Ищу по заголовкам, если указана строка поиска:
            if(Input::get('search') != null) {
                $ads->where('title', 'like', '%' . Input::get('search') . '%');
                $ads_full->where('title', 'like', '%' . Input::get('search') . '%');
            }
            
            // Ищу по связям с категориями:
            if(Input::get('categories_ids') != null) {
                $ads->whereHas('categories', function ($query) use ($categories_ids) {
                    $query->whereIn('category_id', $categories_ids);
                });
                $ads_full->whereHas('categories', function ($query) use ($categories_ids) {
                    $query->whereIn('category_id', $categories_ids);
                });
            }
            
            // Ищу вилку цен:
            if(Input::get('price_from') != null and Input::get('price_to') != null) {
                $ads->where('average_price', '>', Input::get('price_from'))->where('average_price', '<', Input::get('price_to'));
                $ads_full->where('average_price', '>', Input::get('price_from'))->where('average_price', '<', Input::get('price_to'));
                
            } else if (Input::get('price_from') != null and Input::get('price_to') == null) {
                
                // Ищу цену начиная с минимального значения:
                $ads->where('average_price', '>', Input::get('price_from'));
                $ads_full->where('average_price', '>', Input::get('price_from'));
                
            } else if (Input::get('price_from') == null and Input::get('price_to') != null) {
                
                // Ищу цену до максимального значения:
                $ads->where('average_price', '<', Input::get('price_to'));
                $ads_full->where('average_price', '<', Input::get('price_to'));
                
            } else {
                
            }

            // Сортирую по типу:
            if(Input::get('type') != null) {
                if(Input::get('type') == 1) { 
                    $ads->orderBy('type', 'asc');
                    $ads_full->orderBy('type', 'asc');
                    
                }
                if(Input::get('type') == 2) { 
                    $ads->orderBy('type', 'desc');
                    $ads_full->orderBy('type', 'desc');
                    
                }
            }
            
            // Сортирую по дате:
            if(Input::get('sort_date') != null) {
                if(in_array(Input::get('sort_date'), $sort)) { 
                    $ads->orderBy('date', Input::get('sort_date'));
                    $ads_full->orderBy('date', Input::get('sort_date'));
                }
            }
            
            // Сортирую по стоимости:
            if(Input::get('sort_price') != null) {
                if(in_array(Input::get('sort_price'), $sort)) { 
                    $ads->orderBy('average_price', Input::get('sort_price'));
                    $ads_full->orderBy('average_price', Input::get('sort_price'));
                }
            }
        
            $ads = $ads->paginate($paginate);
            
            
            // маркери по тим же критеріям
            $ads_full = $ads_full->get(); 

            $markers = array(); 
            
            foreach ($ads_full as $ad_tmp_id => $ad_tmp) {
                
                if($ad_tmp->longitude != null and $ad_tmp->latitude != null) {
                    $markers[$ad_tmp_id]['id'] = $ad_tmp->id;
                    $markers[$ad_tmp_id]['title'] = $ad_tmp->title;
                    $markers[$ad_tmp_id]['address'] = $ad_tmp->address;
                    $markers[$ad_tmp_id]['img'] = $ad_tmp->img;
                    $markers[$ad_tmp_id]['longitude'] = $ad_tmp->longitude;
                    $markers[$ad_tmp_id]['latitude'] = $ad_tmp->latitude;
                }
            }
        
        
        } else {
            // Фильтр по спеціалістам
             // Беру объявлений города:
            if($type > 0) {
                
                // organizations == 1
                $ads = Ads::where('town_id',$favourite_town)
                    ->where('type', $type)
                    ->where('moderation', 1);
                    
                $ads_full = Ads::where('town_id',$favourite_town)
                    ->where('type', $type)
                    ->where('moderation', 1);
                    
            } else {
                // 
                $ads = Ads::where('town_id',$favourite_town)
                    ->where('moderation', 1)
                    ->orderBy('date','desc');
                    
                $ads_full = Ads::where('town_id',$favourite_town)
                    ->where('type', $type)
                    ->where('moderation', 1)
                    ->orderBy('date','desc');

            }
            
            // Ищу по заголовкам, если указана строка поиска:
            if(Input::get('search') != null) {
                $ads->where('title', 'like', '%' . Input::get('search') . '%');
                $ads_full->where('title', 'like', '%' . Input::get('search') . '%');
            }
            
            // Ищу по связям с категориями:
            if(Input::get('categories_ids') != null) {
                $ads->whereHas('categories', function ($query) use ($categories_ids) {
                    $query->whereIn('category_id', $categories_ids);
                });
                $ads_full->whereHas('categories', function ($query) use ($categories_ids) {
                    $query->whereIn('category_id', $categories_ids);
                });
            }
            
            // Ищу вилку цен:
            if(Input::get('price_from') != null and Input::get('price_to') != null) {
                $ads->where('average_price', '>', Input::get('price_from'))->where('average_price', '<', Input::get('price_to'));
                $ads_full->where('average_price', '>', Input::get('price_from'))->where('average_price', '<', Input::get('price_to'));
                
            } else if (Input::get('price_from') != null and Input::get('price_to') == null) {
                
                // Ищу цену начиная с минимального значения:
                $ads->where('average_price', '>', Input::get('price_from'));
                $ads_full->where('average_price', '>', Input::get('price_from'));
                
            } else if (Input::get('price_from') == null and Input::get('price_to') != null) {
                
                // Ищу цену до максимального значения:
                $ads->where('average_price', '<', Input::get('price_to'));
                $ads_full->where('average_price', '<', Input::get('price_to'));
                
            } else {
                
            }

            // Сортирую по типу:
            if(Input::get('type') != null) { 
                if(Input::get('type') == 1) { 
                    $ads->orderBy('type', 'asc');
                    $ads_full->orderBy('type', 'asc');
                    
                }
                if(Input::get('type') == 2) { 
                    $ads->orderBy('type', 'desc');
                    $ads_full->orderBy('type', 'desc');
                    
                }
            }

            // Сортирую по дате:
            if(Input::get('sort_date') != null) { 
                if(in_array(Input::get('sort_date'), $sort)) { 
                    $ads->orderBy('date', Input::get('sort_date'));
                    $ads_full->orderBy('date', Input::get('sort_date'));
                }
            }
            
            // Сортирую по стоимости:
            if(Input::get('sort_price') != null) {
                if(in_array(Input::get('sort_price'), $sort)) { 
                    $ads->orderBy('average_price', Input::get('sort_price'));
                    $ads_full->orderBy('average_price', Input::get('sort_price'));
                }
            }
            
            $ads = $ads->paginate($paginate); 
            
            // маркери по тим же критеріям
            $ads_full = $ads_full->get();
        }
            if($return_count == 'paginated') {
                return $ads;
            } else {
                return $ads_full;
            }
            
            
    }
    
    
    
    
}
