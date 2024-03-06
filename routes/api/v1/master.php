<?php

use App\Modules\Inventaris\Controllers\InventarisController;
use App\Modules\Inventaris\Controllers\KategoriController;
use App\Modules\Inventaris\Controllers\RakController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'master', 'as' => 'master.'], function () {
    Route::resource('rak', RakController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('inventaris', InventarisController::class)->except(['store', 'update']);

    Route::get('/inventaris/qr/{id}', [InventarisController::class, 'qrcode'])->name('inventaris.qr');
});
