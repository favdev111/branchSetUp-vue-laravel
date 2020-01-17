<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (!Schema::hasColumn('tb_employee', 'password_encrypt')) {
            Schema::table('tb_employee', function ($table) {
                    $table->string('password_encrypt');
            });
        } 
        
        if (!Schema::hasColumn('tb_technician', 'password_encrypt')) {
            Schema::table('tb_technician', function ($table) {
                    $table->string('password_encrypt');
            });
        } 

        return view('welcome');
    }
}
