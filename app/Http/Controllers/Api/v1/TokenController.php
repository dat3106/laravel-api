<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TokenController extends Controller
{


    public function createToken() {
        $token = auth()->user()->createToken('access-token', ["none"], now()->addMinute(100))->plainTextToken;
        return response()->json([
            'access-token' => $token,
            'message' => 'Create access token successfully'
        ]);
    }

    public function deleteToken(Request $request) {
        $request->user()->currentAccessToken()->delete();
    }



}
