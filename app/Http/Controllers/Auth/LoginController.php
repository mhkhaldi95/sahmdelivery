<?php

namespace App\Http\Controllers\Auth;

use App\Constants\Enum;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index(){
        return view('auth.signin');
    }
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            if(in_array(auth()->user()->role,[Enum::SUPER_ADMIN,Enum::ADMIN]) ){
                return redirect()->route('dashboard.index')->with([
                    'success' => 'تسجيل دخول بنجاح'
                ]);
            }elseif(auth()->user()->role == Enum::PLACE){
                return redirect()->route('places.trips.index')->with([
                    'success' => 'تسجيل دخول بنجاح'
                ]);
            }

        }
        return redirect()->route('login')->with([
            'error' => 'تأكد من اسم المستخدم او كلمة السر'
        ]);
    }
    public function logout(){
        Session::flush();
        auth('web')->logout();

        return redirect()->route('login')->with([
            'success' => 'تم تسجيل الخروج بنجاح'
        ]);
    }
}
