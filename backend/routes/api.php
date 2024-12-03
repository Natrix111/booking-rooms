<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\InformationController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\RoomController;
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

Route::get('rooms', [RoomController::class, 'index']);
Route::get('rooms/filters', [RoomController::class, 'filters']);

Route::get('/info', [InformationController::class, 'index']);
Route::get('/contact', [ContactController::class, 'index']);
Route::get('/reviews', [ReviewController::class, 'getRandomReviews']);

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::put('/contact', [ContactController::class, 'update']);
    Route::put('/info', [InformationController::class, 'update']);
});
