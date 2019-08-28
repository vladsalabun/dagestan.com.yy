<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use URL;
use Storage;
use Auth;
use App\Pages;

class FrontController extends Controller
{
    public function index()
	{
        return view('front.index');
    } 
    public function error404()
	{
        return view('front.404');
    } 
    
    
    // Страница объявления:
    public function ad_page($id)
	{
        return view('front.ad_page', compact('id'));
    }
    
    // Список специалистов:
    public function company_page()
	{
        return view('front.company_page');
    }
    
    // Страница добавления объявления:
    public function add_ad()
	{
        if (Auth::check()){
            return view('front.add_ad');
        }
        return redirect('login'); 
    }
   
    // Статичные страницы:
    public function page_page($slug)
	{
        $page = Pages::where('slug',$slug)->where('publish_status', 1)->first();
        if($page == null) {
            return redirect('/404'); 
        }
        return view('front.page', compact('page'));
    }
   

    public function post_add_ad(Request $request)
	{
        // TODO: auth!
        
        dd($request);
    }
    
    
    
    
    
}
