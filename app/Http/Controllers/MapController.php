<?php
/*
|--------------------------------------------------------------------------
| Author: Vlad Salabun / https://t.me/vlad_salabun 
| Controller: MapController
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
use App\Towns;

class MapController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function map_config_page()
	{

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
        
        return view('cp.AppSettingsView.map_config_page', compact('google_map_key', 'latitude', 'longitude', 'openstreetmap_api_key','maxZoom','initZoom','max_center'));
        
    }
    
    public function post_edit_map_config(Request $request)
	{
        OptionsController::set_option('google_map_key', $request->google_map_key);
        OptionsController::set_option('openstreetmap_api_key', $request->openstreetmap_api_key);
        OptionsController::set_option('latitude', $request->latitude);
        OptionsController::set_option('longitude', $request->longitude);
        
        return redirect(URL::to('/').'/cp/map_config'); 
    }

}