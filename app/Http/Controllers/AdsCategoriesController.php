<?php
/*
|--------------------------------------------------------------------------
| Author: Vlad Salabun / https://t.me/vlad_salabun 
| Controller: AdsCategoriesController
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
use App\AdsCategories;

class AdsCategoriesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

   public function adscategories()
   {
       $items = AdsCategories::orderBy('name', 'asc')->paginate(10);
       
       $categories = AdsCategories::all();
       
       foreach ($categories as $key => $value) {
           $all_categories[$value->id] = $value->name;
       }

       return view('cp.AppAdscategories.adscategories', compact('items','all_categories'));
   }

   public function add_adscategories()
   {
       $items = AdsCategories::where('parent_id',0)->get();
       return view('cp.AppAdscategories.add_adscategories', compact('items'));
   }

   public function post_add_adscategories(Request $request)
   {
       $obj = new Adscategories;
       $obj->name = $request->name;
       $obj->parent_id = $request->parent_id;
       $obj->save();  
       return redirect(URL::to('/').'/cp/edit_adscategories/'.$obj->id);
   }

   public function edit_adscategories($id)
   {
       $categories = AdsCategories::where('parent_id',0)->paginate(10);
       $item = AdsCategories::where('id',$id)->first();
       $children = AdsCategories::where('parent_id',$id)->get();
       
       return view('cp.AppAdscategories.edit_adscategories', compact('item','categories','children'));
   }

   public function post_edit_adscategories(Request $request)
   {
       if(isset($request->delete)) {
           
           // TODO: переместить все объявления из этой категории в Без категории
           $children = AdsCategories::where('parent_id',$request->id)->get();
           foreach ($children as $child) {
               Adscategories::where('id', $child->id)->delete();
           }
           
           Adscategories::where('id', $request->id)->delete();
           return redirect(URL::to('/').'/cp/adscategories');
       }

       // update adscategories 
       if(isset($request->submit)) {
           $obj = Adscategories::where('id', $request->id)->first();
           $obj->name = $request->name;
           $obj->parent_id = $request->parent_id;
           $obj->save(); 
       }

       return redirect(URL::to('/').'/cp/edit_adscategories/'.$obj->id); 

   }

}