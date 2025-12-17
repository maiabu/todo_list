<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use app\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request){
        $validate =$request->validate([
            'name'=>['requried','string','max:255'],
            'email'=>['required','email','max:255','unique'],
            'password'=>['required','confirmed','min:8']
        ]);

        $user =User::create([
            'name'=>$validate['name'],
            'email'=>$validate['email'],
            'password'=>Hash::make($validate['password'])
        ]);

        $token =$user->createToken('api_token')->plainTextToken;

        return response()->json([
            'status'=>true,
            'message'=>'تم انشاء الحساب بنجاح',
            'data'=>[
                'id'=>$user->id,
                'name'=>$user->name,
                'email'=>$user->email,
                'token'=>$token
            ]
            ]);
    }

    public function login(Request $request){
        $validate =$request->validate([
            'email'=>['required','email'],
            'password'=>['required','min:8']
        ]);

        if(Auth::attempt($request->only('email','password'))){
            return response()->json([
                'status'=>false,
                'message'=>'invalid credientials'
            ]);

            $token =$user->createToken('Auth_token')->plainTextToken;

            return response()->json([
                'status'=>true,
                'message'=>'login successfully',
                'data'=>[
                'id'=>$user->id,
                'name'=>$user->name,
                'email'=>$user->email,
                'token'=>$token
            ]
                ]);
        }
    }
}
