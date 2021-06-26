<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\LoginRequest;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function test()
    {
        $user = Auth::user();
        ## get user from role
        $role = Role::all();
       // return $role[0]->users;
        return $role[1];

        ## get role from user
        // $user->roles()->attach(2);
        // $user->roles()->detach(2);
        // return $user->roles;
        ## check has role
        // if ($user->hasRole('super'))
        //     echo  'yes';
        // else
        //     return 'no';
    }
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
