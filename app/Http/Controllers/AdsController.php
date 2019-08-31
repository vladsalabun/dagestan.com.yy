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
   
class AdsController extends Controller
{

   public function ads()
   {
       // TODO: Главная страница: ads 
       $items = Ads::orderBy('id', 'desc')->paginate(10);
       return view('cp.AppAds.ads', compact('items'));
   }

   public function add_ads()
   {
       // TODO: Страница добавления: ads 
       return view('cp.AppAds.add_ads');
   }

   public function post_add_ads(Request $request)
   {

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