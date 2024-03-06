<?php

use App\Modules\Inventaris\Controllers\KategoriController;
use App\Modules\Inventaris\Controllers\RakController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'master'], function () {
    Route::resource('rak', RakController::class);
    Route::resource('kategori', KategoriController::class);
});
