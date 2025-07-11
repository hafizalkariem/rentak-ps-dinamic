<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ConsoleController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AdminGameController;
use App\Http\Controllers\Api\AdminEventController;
use App\Http\Controllers\Api\GenreController;

// Public routes
Route::prefix('v1')->group(function () {
    // Auth
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    // Consoles
    Route::apiResource('consoles', ConsoleController::class);

    // Games
    Route::apiResource('games', GameController::class);

    // Genres
    Route::get('genres', [GenreController::class, 'index']);

    // Events
    Route::apiResource('events', EventController::class);
    Route::post('events/{event}/register', [EventController::class, 'register'])->middleware('auth:sanctum');

    // Bookings
    Route::get('bookings/check-availability', [BookingController::class, 'checkAvailability']);
    Route::apiResource('bookings', BookingController::class);

    // Dashboard
    Route::get('dashboard/stats', [DashboardController::class, 'getStats']);
});

// Protected routes
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);

    // Admin routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard']);
        Route::get('users', [AdminController::class, 'users']);
        Route::get('bookings', [AdminController::class, 'bookings']);
        Route::put('bookings/{id}/status', [AdminController::class, 'updateBookingStatus']);

        // Admin Game Management
        Route::apiResource('games', AdminGameController::class);

        // Admin Event Management
        Route::apiResource('events', AdminEventController::class);
    });
});
