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
use App\UserStars;
   
class StarsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function estimate(Request $request)
    {
        $obj = Ads::where('id', $request->ad)->first();
        
        if($obj != null) {
            
            $array['status'] = 200;
            
            UserStars::where('ad_id', $request->ad)->where('user_id', Auth::user()->id)->delete();
            
            DB::table('user_stars')->insertGetId(
                array(
                    'ad_id' => $request->ad,
                    'user_id' => Auth::user()->id,
                    'stars' => $request->stars,
                )
            );
            
            $allStars = UserStars::where('ad_id', $request->ad)->get();
            
            $sum = 0; 
            
            foreach ($allStars as $key => $value) {
                $sum += $value->stars;
            }
            
            $array['average_stars'] = round($sum / count($allStars), 2 );
            $array['new_stars'] = $request->stars;
            
            $obj->stars = $array['average_stars'];
            $obj->save();
            
        } else {
            $array['status'] = 404;
        }

        return response()->json($array);

    }
}