<?php

use App\Http\Controllers\v1\Service;
use Illuminate\Support\Facades\Route;
use Spatie\ResponseCache\Middlewares\CacheResponse;

Route::post('/', Service\StoreController::class)->name('store');

Route::middleware([CacheResponse::class])->group(function() {
    Route::get('/', Service\IndexController::class)->name('index');
    Route::get('{ulid}', Service\ShowController::class)->name('show');
});

Route::put('{service}', Service\UpdateController::class)->name('update');
Route::delete('{service}', Service\DeleteController::class)->name('delete');
