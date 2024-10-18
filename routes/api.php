<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function() {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('services')->as('services:')->group(base_path('routes/V1/services.php'));

    Route::prefix('credentials')->as('credentials:')->group(base_path('routes/V1/credentials.php'));

    Route::prefix('checks')->as('checks:')->group(base_path('routes/V1/checks.php'));
});