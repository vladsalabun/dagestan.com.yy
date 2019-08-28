<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use URL;
use Storage;
use App\Pages;

class PagesController extends Controller
{
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
    
    public function edit_page($id)
	{
        $count = 10;
        
        $pages = Pages::orderBy('date', 'desc')->paginate($count);
        
        return view('cp.AppPages.index', compact('pages'));
    }
    
 
 
}
