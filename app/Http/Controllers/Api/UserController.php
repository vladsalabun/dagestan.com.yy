<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Mail;
use Validator;

class UserController extends Controller
{
    public $successStatus = 200;

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'surname' => 'required',
            'tel' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        //        $input = $request->all();
        //        $input['password'] = bcrypt($input['password']);

        $user = User::create([
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'email' => $request->input('email'),
            'tel' => $request->input('tel'),
            'password' => Hash::make($request->input('password')),
            'activate' => 1
        ]);
        $accessToken =  $user->createToken('AppName')->accessToken;
        return response()->json(['user' => $user, 'access_token' => $accessToken], 200);
    }

    public function login(Request $request)
    {
        $data =  $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);
        if (!auth()->attempt($data)) {
            //return return response()->json($data, 200, $headers);
            return response(['message' => 'Login failed. wrong email or password'], 500);
        }
        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        return response()->json(['user' => auth()->user(), 'access_token' => $accessToken], 200);
    }
    //TODO: forget password
    public function forgetPassword(Request $request)
    {

        $email = $request->input('email');
        $model = (new User())->where('email', $email)->first();
        //        return response([$email, $model->email],500);
        if ($email == $model->email) {
            try {
                $newPass = Str::random(8);
                $model->password = Hash::make($newPass);
                $model->save();
                $name = $model->name;
                Mail::send('mail/mail', array('newPass' => $newPass, 'email' => $email), function ($message) use ($email, $name) {
                    $message->to($email, $name)->subject('forgeting password');
                    $message->from('strawhat2302@gmail.com', 'strawhat');
                });
                Session::flash('flash_message', 'Send message successfully!');

                return response(['message' => 'send mail successfully', 'success' => 1], 200);
            } catch (\Exception $e) {
                Log::error($e);
                return response()->json($model, 500);
            }
        } else {
            return response()->json(['success' => 'your email failed'], 500);
        }
    }

    //TODO: change password
    public function changePassword(Request $request)
    {

        $user_id = $request->user_id;
        $currentPass = $request->currentPass;
        $newPass = $request->newPass;
        $confirmPass = $request->confirmPass;

        $model = (new User())->find($user_id);

        if (Hash::check($request->currentPass, $model->password) == 1) {
            if ($newPass != $confirmPass) {
                return response('confirmation password must match new password', 500);
            } else {
                if ($currentPass == $newPass) {
                    return response('new password must be different current password', 500);
                } else {
                    try {
                        $model->password = Hash::make($newPass);
                        $model->save();
                        return response('change password successfully!', 200);
                    } catch (\Exception $e) {
                        Log::error($e);
                        return response()->json([$model, 'success' => 0], 500);
                    }
                }
            }
        } else {
            return response('current password is failed', 500);
        }
    }




    //TODO: change profile
    public function updateProfile(Request $request)
    {

        $user_id = $request->user_id;
        $name = $request->name;
        $tel = $request->tel;

        $model = (new User())->find($user_id);

        $model->tel = $tel;
        $model->name = $name;
        $model->save();
        return response('change password successfully!', 200);

    }

}