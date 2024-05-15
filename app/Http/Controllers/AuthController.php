<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'user does not exist with that email'], 404);
        }


        if (Hash::check($request->password, $user->password)) {
            $user->tokens()->delete();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json(['message' => 'Logged in successfully', 'token' => $token], 200);
        } else {
            return response()->json(['message' => 'password is incorrect'], 400);
        }
    }
}
