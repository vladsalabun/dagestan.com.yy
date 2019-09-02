<?php
/*
|--------------------------------------------------------------------------
| Author: Vlad Salabun / https://t.me/vlad_salabun 
| Controller: TownsController
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

class TownsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

   public function towns()
   {
       $towns = Towns::orderBy('town', 'asc')->paginate(10);
       return view('cp.AppTowns.towns', compact('towns'));
   }

   public function add_town()
   {
       return view('cp.AppTowns.add_town');
   }

   public function post_add_town(Request $request)
   {
       $obj = new Towns;
       $obj->town = $request->town;
       $obj->save();  
       return redirect(URL::to('/').'/cp/edit_town/'.$obj->id); 
   }

   public function edit_town($id)
   {
       $town = Towns::where('id', $id)->first();
       if($town == null) {
           return redirect(URL::to('/').'/cp/towns'); 
       }
       return view('cp.AppTowns.edit_town', compact('id','town'));
   }

   public function post_edit_town(Request $request)
   {
       if(isset($request->delete)) {
           Towns::where('id', $request->id)->delete();
           return redirect(URL::to('/').'/cp/towns');
       }

       if(isset($request->submit)) {
           $obj = Towns::where('id', $request->id)->first();
           $obj->town = $request->town;
           $obj->save(); 
       }

       return redirect(URL::to('/').'/cp/edit_town/'.$obj->id); 
   }

}