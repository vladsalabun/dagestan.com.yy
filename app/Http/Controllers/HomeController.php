<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;

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
    public function index()
    {
        // TODO: where moderation 0 or 1, 2 - deleted
        $tickets = 1;
        return view('front.home',compact('tickets'));
    }
    
    public function edit()
    {
        $tickets = 1;
        return view('front.home_edit',compact('tickets'));
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
