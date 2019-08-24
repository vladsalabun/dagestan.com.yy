<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use URL;
use Storage;

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
}
