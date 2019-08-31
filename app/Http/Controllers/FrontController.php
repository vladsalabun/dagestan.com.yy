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
use App\Banners;
use App\Towns;

class FrontController extends Controller
{
    public function get_towns()
	{
        return Towns::all();
    }
    public function get_banners()
	{
        return Banners::all();
    }
    
    
    // Главная:
    public function index()
	{
        $towns = $this->get_towns();
        $banners = $this->get_banners();
        return view('front.index', compact('banners','towns'));
    }

    // 404:
    public function error404()
	{
        $towns = $this->get_towns();
        
        return view('front.404', compact('towns'));
    } 
    
    // Страница объявления:
    public function ad_page($id)
	{
        $towns = $this->get_towns();
        
        return view('front.ad_page', compact('id', 'towns'));
    }
    
    // Список специалистов:
    public function company_page()
	{
        $towns = $this->get_towns();
        
        $categories_tree = (new AdsCategories)->get_tree();
        return view('front.company_page', compact('categories_tree', 'towns'));
    }
    
    // Страница добавления объявления:
    public function add_ad()
	{
        $towns = $this->get_towns();

        if(Auth::user()->is_ban == 1) {
            return redirect('/home'); 
        }
        return view('front.add_ad', compact('towns'));
    }
   
    // Статичные страницы:
    public function page_page($slug)
	{
        $towns = $this->get_towns();
        
        $page = Pages::where('slug',$slug)->where('publish_status', 1)->first();
        if($page == null) {
            return redirect('/404'); 
        }
        return view('front.page', compact('page', 'towns'));
    }
   

    public function post_add_ad(Request $request)
	{        
        
        // TODO: 
        dd($request);
    }
    
    public function edit_ad($id)
	{
        $towns = $this->get_towns();
        
        
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
        
        // Если это чужое объявление:
        if($ad->user_id != Auth::user()->id) {
            return redirect(URL::to('/').'/home');
        }
        
        return view('front.edit_ad', compact('ad', 'towns'));

    }
    public function post_edit_ad(Request $request)
	{
        // TODO: 
        dd($request);
    }
    
    
    
    
    
}
