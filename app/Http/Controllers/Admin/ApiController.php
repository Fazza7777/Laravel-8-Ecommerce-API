<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use \Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ApiController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'phone'=>'required|digits_between:7,11',
            'password'=>'required',
            'password_confrim'=> 'required|same:password'
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>500,
                'success'=>false,
                'errors'=>$validator->errors()
             ]);
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json([
            'status'=>200,
            'success'=>true,
            'user'=>$user
         ]);
    }
    public function login(Request $request){
        $cre = $request->only('email','password');
        $token = JWTAuth::attempt($cre);
        if($token){
            return response()->json([
               'status'=>200,
               'success'=>true,
               'token'=>$token
            ]);
        }else{
            return response()->json([
                'status'=>500,
                'success'=>false,

             ]);
        }
    }
    public function me(){
        $user = Auth::user();
        return response()->json([
            'status'=>200,
            'success'=>true,
            'user'=>$user
         ]);
    }
    public function categories(){
        $categories = Category::all();
        return response()->json([
            'status'=>200,
            'success'=>true,
            'categories'=>$categories
         ]);
    }
    public function subCategories($id){
        $subCategories = SubCategory::where('category_id',$id)->get();
        return response()->json([
            'status'=>200,
            'success'=>true,
            'categories'=>$subCategories
         ]);
    }
}
