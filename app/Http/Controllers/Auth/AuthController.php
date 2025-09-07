<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('login.index');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);


        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $request->merge([

            $fieldType => $request->input('username')

        ]);
        
            
        $remember = $request->input('remember_token');

        $credentials = $request->only($fieldType, 'password');

        return $this->userRoute(

            $credentials,

            $remember,

            ['_token','_method'],

            ['message'=>'Please try again','action'=>'warning']
        );
    }


    public function userRoute($credentials,$remember,$data,$errorM){


        if (Auth::guard('web')->attempt($credentials,$remember)) { 

            return redirect()->route('auth.overview');

        }else{
            
            return back()->with($errorM);

        }

        return $this->userRoute(

            $credentials,

            $remember,

            ['_token','_method'],

            ['msg'=>'Please try again','action'=>'warning']
        );


    }

    public function signOut(){

        if (Auth::guard('web')->check()) {

            Auth::guard('web')->logout();

            return redirect()->route('login.index');

        }

    }
}
