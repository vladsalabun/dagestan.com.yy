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
    
}
