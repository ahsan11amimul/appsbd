<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
   // public  Register Api
    public function register(Request $request)
    {
        $validateData=$request->validate([
          'name'=>'required|string',
          'email'=>'required|email|string|unique:users,email',
          'password'=>[
              'required',
              'confirmed',
              Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised(3)
          ]
        ]);
        $validateData['password']=bcrypt($validateData['password']);
        $user=User::create($validateData);
       
        $token=$user->createToken('Laravel')->accessToken;
        return response([
            'user'=>$user,
            'token'=>$token
        ]);
    }
    //public Login Api

    public function login(Request $request)
    {
         $validateData=$request->validate([
          'email'=>'required|email|string',
          'password'=>'required|string|min:8',
          
            ]);
        
        if(!Auth::attempt($validateData))
        {
              return response()->json([
                  'error'=>'invalid credentials'
              ],422);
        }
        $user=Auth::user();
        $token=$user->createToken('Laravel')->accessToken;
        return response([
            'user'=>$user,
            'token'=>$token
        ]);
       // return response()->json(['user'=>$user,'token'=>$token], 201);
    }
    public function logout (Request $request) 
    {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}
