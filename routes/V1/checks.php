
<?php

use Illuminate\Support\Facades\Route;

Route::get('/',)->name('index');
Route::post('/',)->name('store');
Route::get('{checks}',)->name('show');
Route::put('{checks}',)->name('update');
Route::delete('{checks}',)->name('delete');
