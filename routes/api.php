<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->as('v1:')->group(function () {
    Route::get('/', fn () => response()->json(request()->route()))->middleware(['sunset:'.now()->subDays(3)]);

    Route::middleware(['throttle:api'])->group(function () {

        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        Route::prefix('services')->as('services:')->group(base_path('routes/v1/services.php'));

        Route::prefix('credentials')->as('credentials:')->group(base_path('routes/v1/credentials.php'));

        Route::prefix('checks')->as('checks:')->group(base_path('routes/v1/checks.php'));
    });
});
