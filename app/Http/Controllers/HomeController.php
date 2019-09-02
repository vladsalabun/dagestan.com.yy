<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;
use App\Towns;
use App\Ads;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function get_towns()
	{
        return Towns::all();
    }
    public function get_banners()
	{
        return Banners::all();
    }
    
    public function index()
    {
        // TODO: where moderation 0 or 1, 2 - deleted
        $towns = $this->get_towns();
        $ads = Ads::where('user_id', Auth::user()->id)->orderBy('id','desc')->get();
        return view('front.home',compact('towns','ads'));
    }
    
    public function edit()
    {
        $towns = $this->get_towns();
        return view('front.home_edit',compact('towns'));
    }
    
    
    public function changePassword(Request $request) 
    {
 
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Неверный пароль!");
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","Новый пароль не может совпадать со старым!");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->tel = $request->tel;
        $user->save();

        return redirect()->back()->with("success","Данные успешно изменены!");

    }    
    
}
