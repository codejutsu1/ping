<?php

use Illuminate\Support\Facades\Route;


Route::get('/',)->name('index');
Route::post('/',)->name('store');
Route::get('{service}',)->name('show');
Route::put('{service}',)->name('update');
Route::delete('{service}',)->name('delete');
