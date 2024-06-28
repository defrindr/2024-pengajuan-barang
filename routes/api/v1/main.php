<?php

use App\Http\Controllers\MainController;
use App\Modules\Transaksi\Controllers\PengajuanKeluarController;
use App\Modules\Transaksi\Controllers\PengajuanMasukController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'main', 'as' => 'main.', 'middleware' => 'auth:api'], function () {
    Route::get('/dashboard', [MainController::class, 'dashboard'])->name('dashboard');

    Route::post('/pengajuan-masuk/{id}/status/{type}', [PengajuanMasukController::class, 'status']);
    Route::resource('/pengajuan-masuk', PengajuanMasukController::class)->except(['update', 'show']);
    Route::resource('/pengajuan-keluar', PengajuanKeluarController::class)->except(['update', 'show']);
    Route::post('/pengajuan-keluar/{id}/status/back', [PengajuanKeluarController::class, 'back']);
    Route::post('/pengajuan-keluar/{id}/status/{type}', [PengajuanKeluarController::class, 'status']);
});
