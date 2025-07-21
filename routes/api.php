<?php

use App\Http\Controllers\OperatorController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\SwapHistoryController;

use Illuminate\Support\Facades\Route;

Route::get('getAllStations', [StationController::class, 'index']);
Route::get('getAllOperators', [OperatorController::class, 'index']);
Route::get('swap-histories', [SwapHistoryController::class, 'index']);
Route::get('swap-histories/user/{userId}', [SwapHistoryController::class, 'userHistory']);
Route::post('swap-histories', [SwapHistoryController::class, 'store']);

;