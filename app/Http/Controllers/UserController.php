<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Api\v1\TokenController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request) {

        $this->validate($request, [
           'email' => 'required|max:255|email',
            'password' => 'required|confirmed',
        ]);

        if(!Auth::attempt($request->all())) {
            return response([
                'message' => 'Password or Email wrong!'
            ], 201);
        }
        $user = Auth::user() ;
        $token = $user->createToken('access-token', ["none"], now()->addMinute(100) )->plainTextToken;
        $reponse = [
            'user'=> $user,
            'access-token' => $token
        ];
        return response($reponse, 201);
    }

    public function logout(Request $request) {
        $token = new TokenController();
        $token->deleteToken($request);
    }

    public function register(Request $request) {
        $user = $request->all();
        $response = [
            'name' => $user["name"],
            'email' => $user["email"],
            'password' => Hash::make($user["password"]),
        ];
        User::create($response);
        return response([
            'message' => 'Register successfully',
        ], 200);
    }





}
