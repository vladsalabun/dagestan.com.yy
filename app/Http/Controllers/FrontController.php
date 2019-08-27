<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use URL;
use Storage;
use Auth;

class FrontController extends Controller
{
    public function index()
	{
        return view('front.index');
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
    

    public function post_add_ad(Request $request)
	{
        // TODO: auth!
        
        dd($request);
    }
    
    
    
}
