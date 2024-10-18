
<?php

use App\Http\Controllers\Check;
use Illuminate\Support\Facades\Route;

Route::get('/', Check\IndexController::class)->name('index');
Route::post('/', Check\StoreController::class)->name('store');
Route::get('{checks}', Check\ShowController::class)->name('show');
Route::put('{checks}', Check\UpdateController::class)->name('update');
Route::delete('{checks}', Check\DeleteController::class)->name('delete');
