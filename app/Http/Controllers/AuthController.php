<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

#models
use App\Models\User;

class AuthController extends Controller
{
    public function logout(Request $request){
        $user_id = auth()->user()->id;
        auth()->user()->tokens()->delete();
        return response()->json([
            'user_id' => $user_id,
            'message' => 'Logged Out'
        ], 201);
    }
    public function me(Request $request){
        return $request->user();    
    }
    public function login(Request $request){
        if(!Auth::attempt($request->only('email', 'password'))){
            $response = [
                'message' => 'Invalid login credentials!'
            ];
            return response($response, 401);
        }else {
            $user = User::where('email', $request->email)->firstOrFail();
            $token = $user->createToken('auth_token')->plainTextToken;
            $response = [
                'access_token' => $token,
                'token_type'   => 'Bearer'
            ];
            return response($response, 201);
            return $user;
        }
    }
    public function register(Request $request){
        $validatedData = $request->validate([
            'fname'    => 'required|string|max:255',
            'lname'    => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|min:6|unique:users',  
            'password' => 'required|string|min:8'
        ]);

        $user = new User;
        $user->fname = $validatedData['fname'];
        $user->lname = $validatedData['lname'];
        $user->email = $validatedData['email'];
        $user->name = $validatedData['fname'] . " " . $validatedData['lname'];
        $user->username = $validatedData['username'];
        $user->password = Hash::make($validatedData['password']);
        $user->save();

        $token = $user->createToken('auth_token')->plainTextToken;

        $response = [
            'access_token' => $token,
            'token_type'   => 'Bearer'
        ];
        return response($response, 201);
        // return $user;
        // return "Registering new User..";
    }
}
