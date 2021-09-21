<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class LoginController extends Controller
{


    protected $redirectTo ="/admin/dashboard";//RouteServiceProvider::HOME
    
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        $title="Login";
        return view('admin.login',compact('title'));
    }
}
