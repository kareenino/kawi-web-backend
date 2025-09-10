<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:120'],
            'email'    => ['nullable', 'email', 'max:255', Rule::unique('users', 'email')],
            'phone'    => ['required', 'string', 'max:30', Rule::unique('users', 'phone')],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'] ?? null,
            'phone'    => $data['phone'],
            'password' => Hash::make($data['password']),
        ]);

        $token = $user->createToken('rider-app')->plainTextToken;

        return response()->json([
            'message' => 'Registered successfully',
            'token'   => $token,
            'user'    => $user,
        ], 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'login'    => ['required', 'string'], // phone or email
            'password' => ['required', 'string'],
        ]);

        $user = User::where('phone', $data['login'])
            ->orWhere('email', $data['login'])
            ->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            // 401 is the right status for invalid credentials
            return response()->json(['message' => 'Invalid email/phone or password.'], 401);
        }

        $token = $user->createToken('rider-app')->plainTextToken;

        return response()->json([
            'message' => 'Logged in',
            'token'   => $token,
            'user'    => $user,
        ], 200);
    }

    public function me(Request $request)
    {
        return response()->json(['user' => $request->user()]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}
