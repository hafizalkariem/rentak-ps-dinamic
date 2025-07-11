<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/health', function () {
    return response()->json([
        'status' => 'OK',
        'timestamp' => now(),
        'app' => config('app.name'),
        'env' => config('app.env')
    ]);
});

Route::get('/', function () {
    return response()->json([
        'message' => 'Laravel API is running',
        'version' => app()->version()
    ]);
});
