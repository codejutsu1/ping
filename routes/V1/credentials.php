<?php

use App\Http\Controllers\Credential;
use Illuminate\Support\Facades\Route;

Route::get('/', Credential\IndexController::class)->name('index');
Route::post('/', Credential\StoreController::class)->name('store');
Route::get('{credential}', Credential\ShowController::class)->name('show');
Route::put('{credential}', Credential\UpdateController::class)->name('update');
Route::delete('{credential}', Credential\DeleteController::class)->name('delete');
