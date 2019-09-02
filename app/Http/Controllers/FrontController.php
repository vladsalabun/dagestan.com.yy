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
        $banners = $this->get_banners();
        $ads = Ads::orderBy('id','desc')->get();
        return view('front.index', compact('banners','towns','ads'));
    }

    // 404:
    public function error404()
	{
        $towns = $this->get_towns();
        
        return view('front.404', compact('towns'));
    } 
    
    // Страница объявления:
    public function ad_page($id)
	{
        $towns = $this->get_towns();
        $ad = Ads::where('id',$id)->first();
        if($ad == null) {
            return redirect(URL::to('/').'/404'); 
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
        
        
        return view('front.ad_page', compact('id', 'towns','ad', 'google_map_key', 'latitude', 'longitude', 'openstreetmap_api_key','maxZoom','initZoom','max_center'));
    }
    
    // Список специалистов:
    public function company_page()
	{
        $towns = $this->get_towns();
        
        $categories_tree = (new AdsCategories)->get_tree();
        return view('front.company_page', compact('categories_tree', 'towns'));
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
                        'ads/',
                        $uploadedFile,
                        $banner_filename
                    );
                    
                    // Обновляю banner:
                    Ads::where('id', $obj->id)
                    ->update(
                        array(
                            'img' => 'ads/'.$banner_filename, 
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
        // TODO: 
        dd($request);
    }
    
    
    
    
    
}
