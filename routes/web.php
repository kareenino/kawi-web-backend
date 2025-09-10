<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// SPA auth for Vue → session login
Route::post('/spa/login', function (Request $request) {
    $creds = $request->validate([
        'email' => ['required','email'],
        'password' => ['required'],
    ]);

    if (! Auth::attempt($creds, true)) {
        return response()->json(['message' => 'Invalid credentials'], 422);
    }

    $user = $request->user();

    if ($user->hasRole('rider')) {
        Auth::logout();
        return response()->json(['message' => 'Web admin is only for operators & super-admins'], 403);
    }

    $request->session()->regenerate();
    return response()->noContent(); // 204 – front-end redirects to /admin
})->middleware(['web']);

Route::post('/spa/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return response()->noContent();
})->middleware(['web']);