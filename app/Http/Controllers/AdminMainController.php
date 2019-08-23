<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use URL;
use Storage;

class AdminMainController extends Controller
{
    public function index()
	{
        return view('cp.index');
    } 

    public function banners() {
        return view('cp.AppBanners.index');
    }
    public function ads_categories() {
        return view('cp.AppCategories.index');
    }
    public function ads() {
        return view('cp.AppAds.index');
    }
    public function towns() {
        return view('cp.AppTowns.index');
    }
    
    
}
