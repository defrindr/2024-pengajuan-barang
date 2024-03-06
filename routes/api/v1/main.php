<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'main', 'as' => 'main.'], function () {
    Route::get('/dashboard', [MainController::class, 'dashboard'])->name('dashboard');
});
