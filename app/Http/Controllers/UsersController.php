<?php
/*
|--------------------------------------------------------------------------
| Author: Vlad Salabun / https://t.me/vlad_salabun 
| Controller: UsersController
|--------------------------------------------------------------------------
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;
use URL;
use Storage;
use File;
use Auth;
use App\Users;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


   public function users()
   {
       $items = Users::orderBy('name', 'asc')->paginate(10);
       return view('cp.AppUsers.users', compact('items'));
   }

   public function add_users()
   {
       // TODO: Страница добавления: users 
       return view('cp.AppUsers.add_users');
   }

   public function post_add_users(Request $request)
   {

       // TODO: Создать запись:
       $obj = new Users;

       $obj->title = $request->title;

       $obj->save();  

       return redirect(URL::to('/').'/cp/edit_users/'.$obj->id); 

   }

   public function edit_users($id)
   {
       $item = Users::where('id',$id)->first();
       return view('cp.AppUsers.edit_users', compact('id','item'));
   }

   public function post_edit_users(Request $request)
   {
       // TODO: Delete users:
       if(isset($request->delete)) {
           Users::where('id', $request->id)->delete();
           return redirect(URL::to('/').'/cp/users');
       }

       // TODO: update users 
       if(isset($request->submit)) {
           $obj = Users::where('id', $request->id)->first();
           $obj->name = $request->name;
           $obj->email = $request->email;
           $obj->address = $request->address;
           $obj->tel = $request->tel;
           $obj->is_ban = $request->is_ban;
           $obj->role_id = $request->role_id;

           $obj->save(); 
       }

       return redirect(URL::to('/').'/cp/edit_users/'.$obj->id); 

   }

}