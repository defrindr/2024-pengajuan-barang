<?php

use App\Http\Controllers\MainController;
use App\Modules\Transaksi\Controllers\PengajuanKeluarController;
use App\Modules\Transaksi\Controllers\PengajuanMasukController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'main', 'as' => 'main.', 'middleware' => 'auth:api'], function () {
    Route::get('/dashboard', [MainController::class, 'dashboard'])->name('dashboard');

    Route::resource('/pengajuan-masuk', PengajuanMasukController::class)->except(['update', 'show']);
    Route::resource('/pengajuan-keluar', PengajuanKeluarController::class)->except(['update', 'show']);
});
