<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function home(){
        return view('home');
    }
    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
}
