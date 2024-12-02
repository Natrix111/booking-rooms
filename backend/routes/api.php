<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\InformationController;
use App\Http\Controllers\Api\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/info', [InformationController::class, 'index']);
Route::get('/contact', [ContactController::class, 'index']);
Route::get('/reviews', [ReviewController::class, 'getRandomReviews']);


