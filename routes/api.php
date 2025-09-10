<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FAQController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BikeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\EcopointController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\StationReviewController;
use App\Http\Controllers\SwapHistoryController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
// Route::post('login', [AuthController::class, 'login']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// Protected (token required)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me',     [AuthController::class, 'me']);
    Route::post('/logout',[AuthController::class, 'logout']);

Route::post('/stations/{station}/reviews', [StationReviewController::class, 'store']);

});

//favorites
Route::get('favorites', [FavoriteController::class, 'index']);
Route::get('favorite/{id}', [FavoriteController::class, 'getFavorite']);
Route::post('saveFavorite', [FavoriteController::class, 'store']);
Route::put('updateFavorite/{id}', [FavoriteController::class, 'updateFavorite']);
Route::delete('deleteFavorite/{id}', [FavoriteController::class, 'deleteFavorite']);

//ecopoints
Route::get('ecopoints', [EcopointController::class, 'index']);
Route::get('ecopoint/{id}', [EcopointController::class, 'getEcopoint']);
Route::post('saveEcopoint', [EcopointController::class, 'store']);
Route::put('updateEcopoint/{id}', [EcopointController::class, 'updateEcopoint']);
Route::delete('deleteEcopoint/{id}', [EcopointController::class, 'deleteEcopoint']);

//payments
Route::get('payments', [PaymentController::class, 'index']);
Route::get('payments/{id}', [PaymentController::class, 'getPayment']);
Route::post('savePayment', [PaymentController::class, 'store']);
Route::put('updatePayment/{id}', [PaymentController::class, 'updatePayment']);
Route::delete('deletePayment/{id}', [PaymentController::class, 'deletePayment']);

//bikes
Route::get('bikes', [BikeController::class, 'index']);
Route::get('/bikes/{id}', [BikeController::class, 'getBike'])
     ->whereNumber('id');
Route::post('saveBike', [BikeController::class, 'store']);
Route::put('updateBike/{id}', [BikeController::class, 'updateBike']);
Route::delete('deleteBike/{id}', [BikeController::class, 'deleteBike']);

Route::get('/users/{user}/bike', [BikeController::class, 'showForUser'])
    ->whereNumber('user');

//faqs
Route::get('faqs', [FAQController::class, 'index']);
Route::get('faq/{id}', [FAQController::class, 'getFaq']);
Route::post('saveFaq', [FAQController::class, 'store']);
Route::put('updateFaq/{id}', [FAQController::class, 'updateFaq']);
Route::delete('deleteFaq/{id}', [FAQController::class, 'deleteFaq']);

//reviews
Route::get('reviews', [ReviewController::class, 'index']);
Route::get('review/{id}', [ReviewController::class, 'getReview']);
Route::post('saveReview', [ReviewController::class, 'store']);
Route::put('updateReview/{id}', [ReviewController::class, 'updateReview']);
Route::delete('deleteReview/{id}', [ReviewController::class, 'deleteReview']);

//reviews by station
Route::get('/stations/{station}/reviews', [StationReviewController::class, 'index']);

//articles
Route::get('articles', [ArticleController::class, 'index']);
Route::get('article/{id}', [ArticleController::class, 'getArticle']);
Route::post('saveArticle', [ArticleController::class, 'store']);
Route::put('updateArticle/{id}', [ArticleController::class, 'updateArticle']);
Route::delete('deleteArticle/{id}', [ArticleController::class, 'deleteArticle']);

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

//for testing
Route::get('/ping', fn() => response()->json(['ok' => true]));