<?php

use App\Http\Controllers\Api\AmenityController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\InformationController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [UserController::class, 'index']);
    Route::delete('/user/bookings/{id}', [BookingController::class, 'userdelete']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/login', function () {
    return response()->json(['Ошибка' => 'Недействительный токен'], 401); 
})->name('login');


Route::get('rooms', [RoomController::class, 'index']);
Route::get('rooms/filters', [RoomController::class, 'filters']);
Route::get('/rooms/{id}', [RoomController::class, 'show']);

Route::get('/info', [InformationController::class, 'index']);
Route::get('/contact', [ContactController::class, 'index']);
Route::get('/reviews', [ReviewController::class, 'getRandomReviews']);

Route::post('/bookings', [BookingController::class, 'store'])->middleware('auth:sanctum');

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::patch('/contact', [ContactController::class, 'update']);
    Route::patch('/info', [InformationController::class, 'update']);

    Route::get('/amentities', [AmenityController::class, 'index']);
    Route::post('/amentities', [AmenityController::class, 'create']);
    Route::patch('/amentities/{id}', [AmenityController::class, 'update']);
    Route::delete('/amentities/{id}', [AmenityController::class, 'delete']);

    Route::post('rooms', [RoomController::class, 'create']);
    Route::patch('rooms/{id}', [RoomController::class, 'update']);
    Route::delete('rooms/{id}', [RoomController::class, 'delete']);

    Route::get('/bookings', [BookingController::class, 'index']);
    Route::post('/bookings/{id}/approve', [BookingController::class, 'approve']);
    Route::delete('/bookings/{id}', [BookingController::class, 'destroy']);

});
