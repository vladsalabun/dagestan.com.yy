<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use URL;
use Storage;
use App\Pages;
use Illuminate\Support\Str;

class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
	{
        $count = 10;
        
        $pages = Pages::orderBy('date', 'desc')->paginate($count);
        
        return view('cp.AppPages.index', compact('pages'));
    }

    public function add_page()
	{
        return view('cp.AppPages.add_page');
    }
    public function post_add_page(Request $request)
	{
        
        // Создаю слаг:
        $slug = Str::slug($request->title, '-');
        
        // Проверяю есть ли в базе данных такой слаг:
        $check_slug = Pages::where('slug', $slug)->first();
        
        // Если дубль, изменяю слаг:
        if($check_slug != null) {
            $slug = $slug . '_' . rand(9999,99999);
        }

        // Создаю запись:
        $obj = new Pages;

        $obj->slug = $slug;
        $obj->title = $request->title;
        $obj->text = $request->text;
        $obj->date = $request->publish_date . ' ' . $request->time;
        $obj->publish_status = $request->publish_status;
        
        $obj->save();        

        return redirect(URL::to('/').'/cp/edit_page/'.$obj->id); 
        
    }

    
    public function edit_page($id)
	{
        
        $page = Pages::where('id', $id)->first();
        
        if($page == null) {
            return redirect(URL::to('/').'/cp/pages'); 
        }
        
        return view('cp.AppPages.edit_page', compact('page'));
        
    }
    
    public function post_edit_page(Request $request)
	{

        if(isset($request->delete)) {
            
            Pages::where('id', $request->id)->delete();
            return redirect(URL::to('/').'/cp/pages');
            
        }
        
        if(isset($request->submit)) {

            // Проверяю есть ли в базе данных такой слаг:
            $obj = Pages::where('id', $request->id)->first();

            $obj->slug = $request->slug;
            $obj->title = $request->title;
            $obj->text = $request->text;
            $obj->date = $request->publish_date . ' ' . $request->time;
            $obj->publish_status = $request->publish_status;
            
            $obj->save(); 
            
        }        

        return redirect(URL::to('/').'/cp/edit_page/'.$obj->id); 
        
    }
    
 
 
}