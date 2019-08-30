<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use URL;
use Storage;

class OptionsController extends Controller
{
    public static function get_option($option_name)
	{
        return DB::table('agargo_config')->where('option_name',$option_name)->get();
    } 
    
    public static function set_option($option_name, $option_value)
	{
        DB::table('agargo_config')
            ->updateOrInsert(
                ['option_name' => $option_name],
                ['option_value' => $option_value]
            );
    } 
}
