<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends Controller
{
    // Login
    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->validated();
            if (!auth()->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            $user = auth()->user();
            $user->tokens()->delete();
            $user->access_token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'user' => $user->makeHidden([ "id", "email_verified_at", "created_at", "updated_at"])
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    // Logout
    public function logout()
    {
        try {
            // Revoke all tokens...
            auth()->user()->tokens()->delete();
            return response()->json(['message' => 'Successfully logged out']);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    // Sign up
    public function signup(SignupRequest $request)
    {
        try {
            [
                'name' => $name,
                'email' => $email,
                'password' => $password
            ] = $request->validated();

            $user = new User;
            $user->name = $name;
            $user->email = $email;
            $user->password = Hash::make($password);

            $user->save();
            return response()->json(['message' => 'Successfully created user!'], 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
