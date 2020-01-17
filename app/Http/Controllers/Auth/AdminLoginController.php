<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{

    use AuthenticatesUsers;

    protected $guard = 'admin';


    protected $redirectTo = '/users';


     public function __construct()

     {

         $this->middleware('guest')->except('logout');

     }



    public function showLoginForm()

    {
        
        return view('auth.adminLogin');
    }



    public function login(Request $request)

    {

        if (auth()->guard('admin')->attempt(['username' => $request->username, 'password' => $request->password])) {

            return redirect('/users');
        } else {
            return back()->withErrors(['email' => 'Password or username are wrong.']);
        }



    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect('/admin-login');
    }
}
