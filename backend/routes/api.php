<?php

use App\Http\Controllers\Api\AmenityController;
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

    Route::get('/amentities', [AmenityController::class, 'index']);
    Route::post('/amentities', [AmenityController::class, 'create']);
    Route::patch('/amentities/{id}', [AmenityController::class, 'update']);
    Route::delete('/amentities/{id}', [AmenityController::class, 'delete']);

    Route::post('rooms', [RoomController::class, 'create']);
    Route::patch('rooms/{id}', [RoomController::class, 'update']);
    Route::delete('rooms/{id}', [RoomController::class, 'delete']);

});
