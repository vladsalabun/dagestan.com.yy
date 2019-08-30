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

class FrontController extends Controller
{
    
    // Главная:
    public function index()
	{
        return view('front.index');
    }

    // 404:
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
        $categories_tree = (new AdsCategories)->get_tree();
        return view('front.company_page', compact('categories_tree'));
    }
    
    // Страница добавления объявления:
    public function add_ad()
	{
        if(Auth::user()->is_ban == 1) {
            return redirect('/home'); 
        }
        return view('front.add_ad');
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
        // TODO: 
        dd($request);
    }
    
    public function edit_ad($id)
	{
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
        
        // TODO: Если это чужое объявление:
        /*
        if($ad->user_id != Auth::user()->id) {
            return redirect(URL::to('/').'/home');
        }
        */
        
        return view('front.edit_ad', compact('ad'));

    }
    public function post_edit_ad(Request $request)
	{
        // TODO: 
        dd($request);
    }
    
    
    
    
    
}
