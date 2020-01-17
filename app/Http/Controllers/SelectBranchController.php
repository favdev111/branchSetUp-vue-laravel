<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SelectBranchController extends Controller
{
    
    public function index(Request $request) {
        $userEmail = $request->input('user_email');
        $userPwd = $request->input('password');
        $userInfo = DB::table('users')->where('email', $userEmail)->first();
        $hasedPwd = Hash::make($userPwd);
        var_dump(Str::random(60));
        // if($hasedPwd == $userInfo->password){

        // }
        die;
   }
}
