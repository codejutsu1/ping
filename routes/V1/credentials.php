<?php

use Illuminate\Support\Facades\Route;

Route::get('/',)->name('index');
Route::post('/',)->name('store');
Route::get('{credential}',)->name('show');
Route::put('{credential}',)->name('update');
Route::delete('{credential}',)->name('delete');
