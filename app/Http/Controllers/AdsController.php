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
   
class AdsController extends Controller
{

   public function ads()
   {
       $items = Ads::orderBy('id', 'desc')->paginate(10);
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
       return view('cp.AppAds.add_ads', compact('towns','google_map_key', 'latitude', 'longitude', 'openstreetmap_api_key','maxZoom','initZoom','max_center','users'));
   }

   public function post_add_ads(Request $request)
   {
        dd($_POST);
       // TODO: Создать запись:
       $obj = new Ads;

       $obj->title = $request->title;

       $obj->save();  

       return redirect(URL::to('/').'/edit_ads/'.$obj->id); 

   }

   public function edit_ads($id)
   {
       // TODO: Страница изменения: ads 
       $item = Ads::where('id',$id)->first();
       if($item == null) {
           return redirect(URL::to('/').'/ads');
       }
       return view('cp.AppAds.edit_ads', compact('id','item'));
   }

   public function post_edit_ads(Request $request)
   {
       // TODO: Delete ads:
       if(isset($request->delete)) {
           Ads::where('id', $request->id)->delete();
           return redirect(URL::to('/').'/');
       }

       // TODO: update ads 
       if(isset($request->submit)) {
           $obj = Ads::where('id', $request->id)->first();
           $obj->title = $request->title;

           $obj->save(); 
       }

       return redirect(URL::to('/').'/edit_ads/'.$obj->id); 

   }

}