<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class authController extends Controller
{
    public function login(Request $request)
    {
        $credential = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $user = User::where('email', $credential['email'])->first();
        if ($user && Hash::check($credential['password'], $user->password)) {
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'token' => $token,
                'status' => '200',
            ]);
        } else if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        } else {
            return response()->json([
                'message' => 'Invalid credential',
            ], 401);
        }
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(["message" => "Logged out successfully"]);
    }

    public function profile(Request $request)
    {
        return response()->json([
            "user" => $request->user(),
        ]);
    }

    public function register(Request $request)
    {
        $valideted = $request->validate([
            "name" => ['required', 'string'],
            "email" => ['required', 'email', 'unique:users,email'],
            "password" => ["required", "string"],
        ]);
        $user = User::create($valideted);
        return response()->json([
            "message" => "User created successfully",
            "user" => $user,
        ]);
    }
}
