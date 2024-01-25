<?php

namespace App\Http\Controllers;



use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;


class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    //use AuthenticatesUsers;



    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        return  redirect('admin');
    }

    function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required|min:1'
        ]);



        if (Auth::attempt(['email' => request('email'), 'password' => request('password'), 'user_type' => 0])) {
            
              $user = Auth::user();
              
              
               $update = new \App\Models\ActivityTracker();
        $update->target_id =   -1;
        $update->target_type = -1;
        $update->contents =   $user->name." Logged in to dashboard ";
        $update->save();
        
              
              $cookie = \Illuminate\Support\Facades\Cookie::make('_dg-v15628', $user->createToken('authToken')->accessToken, 600, null, null, false, false);
              return   redirect('admin/home')->withCookie($cookie);
        } else {
            return back()->with('error', 'username and password are not correct.');
        }
    }


}
