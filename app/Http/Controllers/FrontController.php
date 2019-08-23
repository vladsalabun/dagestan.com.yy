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
        $tickets = 1;
        return view('front.index',compact('tickets'));
    } 
    
    public function new_ticket()
	{
        $tickets = 1;
        return view('front.add_ticket',compact('tickets'));
    }
    
    

}
