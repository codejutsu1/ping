<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\Service;


Route::get('/', Service\IndexController::class)->name('index');
Route::post('/', Service\StoreController::class)->name('store');
Route::get('{service}', Service\ShowController::class)->name('show');
Route::put('{service}', Service\UpdateController::class)->name('update');
Route::delete('{service}', Service\DeleteController::class)->name('delete');
