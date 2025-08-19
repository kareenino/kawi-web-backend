<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\SwapHistoryController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [AuthController::class, 'login']);

//stations
Route::get('stations', [StationController::class, 'index']);
Route::get('station/{id}', [StationController::class, 'getStation']);
Route::post('saveStation', [StationController::class, 'store']);
Route::put('updateStation/{id}', [StationController::class, 'updateStation']);
Route::delete('deleteStation/{id}', [StationController::class, 'deleteStation']);

//operators
Route::get('operators', [OperatorController::class, 'index']);
Route::get('operator/{id}', [OperatorController::class, 'getOperator']);
Route::post('saveOperator', [OperatorController::class, 'store']);
Route::put('updateOperator/{id}', [OperatorController::class, 'updateOperator']);
Route::delete('deleteOperator/{id}', [OperatorController::class, 'deleteOperator']);

//swaphistories
Route::get('swaphistories', [SwapHistoryController::class, 'index']);
Route::get('swaphistory/{id}', [SwapHistoryController::class, 'getSwaphistory']);
Route::post('saveSwaphistory', [SwapHistoryController::class, 'store']);
Route::put('updateSwaphistory/{id}', [SwapHistoryController::class, 'updateSwaphistory']);
Route::delete('deleteSwaphistory/{id}', [SwapHistoryController::class, 'deleteSwaphistory']);