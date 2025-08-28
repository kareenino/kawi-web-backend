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
            'name'     => ['required','string','max:120'],
            'email'    => ['nullable','email','max:255', Rule::unique('users','email')],
            'phone'    => ['required','string','max:30', Rule::unique('users','phone')],
            'password' => ['required','string','min:6'],
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'] ?? null,
            'phone'    => $data['phone'],
            'password' => Hash::make($data['password']),
        ]);

        // issue Sanctum token right after registration
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
            'login'    => ['required','string'], // phone or email
            'password' => ['required','string'],
        ]);

        $user = User::where('phone', $data['login'])
            ->orWhere('email', $data['login'])
            ->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 422);
        }

        $token = $user->createToken('rider-app')->plainTextToken;

        return response()->json([
            'message' => 'Logged in',
            'token'   => $token,
            'user'    => $user,
        ]);
    }

    // Who am I
    public function me(Request $request)
    {
        return response()->json(['user' => $request->user()]);
    }

    // Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}






















    // public function register(Request $request)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required|string',
    //         'email' => 'required|string|email|unique:users',
    //         'password' => 'required|string|min:8|confirmed',
    //         'role_id'=>'required|integer|exists:roles,id'
    //     ]);

    //     $validated['password'] = Hash::make($validated['password']);

    //     try {
    //         $user = User::create($validated);

    //         return response()->json([
    //             'message' => 'Registration Successful!',
    //             'user' => $user
    //         ], 201);
    //     } catch (\Exception $exception) {
    //         return response()->json([
    //             "Error" => "Registration failed: ",
    //             $exception
    //         ], 500);
    //     }
    // }

// public function login(Request $request)
//     {
//         $validated = $request->validate([
//             'email' => 'required|email',
//             'password' => 'required'
//         ]);

//         $user = User::where('email', $validated['email'])->first();

//         if (! $user || ! Hash::check($validated['password'], $user->password)) {
//             return response()->json([
//                 'message' => 'Invalid credentials'
//             ], 401);
//         }

//         $token = $user->createToken('auth-token')->plainTextToken;

//         return response()->json([
//             'message' => 'Login Successful!',
//             'user' => $user,
//             'token' => $token,
//             'role' => $user->getRoleNames()->first(),
//             'abilities' => []  // Optional: Add role-based permissions here
//         ], 200);
//     }

//     public function logout(Request $request) {
//         $request->user()->currentAccessToken()->delete();
//         return response()->json([
//             "Message"=>"Logout Successful."
//         ]);
//     }