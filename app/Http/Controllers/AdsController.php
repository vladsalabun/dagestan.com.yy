<?php
/*
|--------------------------------------------------------------------------
| Author: Vlad Salabun / https://t.me/vlad_salabun 
| Controller: AdsController
|--------------------------------------------------------------------------
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;
use URL;
use Storage;
use File;
use Auth;
use App\Ads;
use App\Towns;
use App\Users;
use App\AdsCategories;
   
class AdsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

   public function ads()
   {
       $items = Ads::orderBy('moderation','asc')->orderBy('date', 'desc')->paginate(10);       
       return view('cp.AppAds.ads', compact('items'));
   }

   public function add_ads()
   {
        $users = Users::All();
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
       
       $towns = Towns::orderBy('town', 'asc')->get();
       $categories = (new AdsCategories)->get_tree();
      
       
       return view('cp.AppAds.add_ads', compact('towns','google_map_key', 'latitude', 'longitude', 'openstreetmap_api_key','maxZoom','initZoom','max_center','users','categories'));
   }

   public function post_add_ads(Request $request)
   {

       // Создать запись:
       $obj = new Ads;

       $obj->type = $request->type;
       $obj->user_id = $request->user_id;
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
       
        // фикс часов:
        if(explode(':',$request->time)[0] < 10) {
            $publish_date = $request->date .' 0'.$request->time.':00';
        } else {
            $publish_date = $request->date .' '.$request->time.':00';
        }
       
       $obj->date = $publish_date;
       $obj->moderation = $request->moderation;
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
       
        if(isset($request->category)) {
            // Категории:
            DB::table('ads_has_categories')->insertGetId(
                array(
                    'ad_id' => $obj->id,
                    'category_id' => $request->category,
                )
            );
        }        
       
       return redirect(URL::to('/').'/cp/edit_ads/'.$obj->id); 

   }

   public function edit_ads($id)
   {
        $users = Users::All();
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
       
       $towns = Towns::orderBy('town', 'asc')->get();
       $categories = (new AdsCategories)->get_tree();
       
       $item = Ads::where('id',$id)->first();
       if($item == null) {
           return redirect(URL::to('/').'/ads');
       }
       
       $ad_category = 0;
       
       foreach ($item->categories as $category) {
           $ad_category = $category->id;
       }
       
       return view('cp.AppAds.edit_ads', compact('id','item', 'towns','google_map_key', 'latitude', 'longitude', 'openstreetmap_api_key','maxZoom','initZoom','max_center','users','categories','ad_category'));
   }

   public function post_edit_ads(Request $request)
   {
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
           return redirect(URL::to('/').'/cp/ads');
       }

       // update ads 
       if(isset($request->submit)) {
           $obj = Ads::where('id', $request->id)->first();

           $obj->type = $request->type;
           $obj->user_id = $request->user_id;
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
       
            // фикс часов:
            if(explode(':',$request->time)[0] < 10) {
                $publish_date = $request->date .' 0'.$request->time.':00';
            } else {
                $publish_date = $request->date .' '.$request->time.':00';
            }
       
           $obj->date = $publish_date;
           $obj->moderation = $request->moderation;
           $obj->name = $request->name;
           $obj->surname = $request->surname;
           $obj->town_id = $request->town_id;
           $obj->working_hours = $request->working_hours;
           $obj->work_expiriens = $request->work_expiriens;
           $obj->average_price = $request->average_price;
      
           $obj->save();  

            // Удаление фото:
            if(isset($request->delete_img)) {
                // удалить файл
                Storage::disk('public')->delete($obj->img);
                
                Ads::where('id', $obj->id)
                ->update(
                    array(
                        'img' => null,
                    )
                );  
            }
           
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
       
       
           // Видаляю категорії:
           DB::table('ads_has_categories')
               ->where('ad_id',$obj->id)
               ->delete();
             
            // Записую ще раз:
            if(isset($request->category)) {
                // Категории:
                DB::table('ads_has_categories')->insertGetId(
                    array(
                        'ad_id' => $obj->id,
                        'category_id' => $request->category,
                    )
                );
            } 
           

           $obj->save(); 
       }

       return redirect(URL::to('/').'/cp/edit_ads/'.$obj->id); 

   }

   public function estimate()
   {

        $array['status'] = 200;
        $array['user_id'] = Auth::user()->name;

        return response()->json($array);

   }
}