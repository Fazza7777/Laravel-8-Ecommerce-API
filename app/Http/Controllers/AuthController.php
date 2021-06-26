<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }
    public function login(LoginRequest $request)
    {
        $phone = $request->phone;
        $password = $request->password;
        $user = User::where('phone', $phone)->first();
        if ($user) {
            if (Hash::check($password, $user->password)) {
                Auth::login($user);
                return redirect()->route('home')->with('login', 'Welcome ' . $user->name);
            } else {
                return redirect()->back()->withErrors(['password' => 'စကား၀ှက်မှားနေပါသည်။']);
            }
        } else {
            return redirect()->back()->withErrors(['phone' => 'ယခု နံပါတ်ဖြင့်အကောင့်မရှိပါ']);
        }
        if ($request->rememberMe == "on") {
            return 'on';
        } else {
            return 'off';
        }
    }
}
