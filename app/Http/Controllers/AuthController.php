<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Authenticate a user and issue a Sanctum token.
     *
     * Validates incoming credentials against the users table. If successful,
     * generates a new plain-text Personal Access Token using Laravel Sanctum.
     *
     * @param \Illuminate\Http\Request $request Incoming request containing 'email' and 'password'.
     *
     * @return \Illuminate\Http\Response JSON response containing the User object and 'auth_token', 
     *                                   or a 401 response on bad credentials.
     *
     * @throws \Illuminate\Validation\ValidationException If request validation fails.
     */
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password'=> 'required|string',
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response(['user' => $user, 'token' => $token], 201);
    }

    /**
     * Register a new user and issue an initial Sanctum token.
     *
     * Validates the provided fields, hashes the user's password using bcrypt,
     * creates the new User record, and automatically generates an authentication token.
     *
     * @param \Illuminate\Http\Request $request Incoming request containing 'name', 'email', 'password', and 'password_confirmation'.
     *
     * @return \Illuminate\Http\Response JSON response containing the newly created User object and 'auth_token' (201 status).
     *
     * @throws \Illuminate\Validation\ValidationException If request validation fails (e.g., email not unique or password not confirmed).
     */
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password'=> 'required|string|confirmed',
        ]);
/**
     * Revoke the current authentication token.
     *
     * Extracts the currently authenticated user from the request and deletes
     * exactly the Personal Access Token that was used to make the request.
     *
     * @param \Illuminate\Http\Request $request Incoming authenticated request.
     *
     * @return \Illuminate\Http\Response JSON response with a success message.
     */
    
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response(['user' => $user, 'token' => $token], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response(['message' => 'Logged out successfully']);
    }
}
