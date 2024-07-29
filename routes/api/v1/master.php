<?php

use App\Modules\Inventaris\Controllers\InventarisController;
use App\Modules\Inventaris\Controllers\KategoriController;
use App\Modules\Inventaris\Controllers\RakController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'master', 'as' => 'master.',
], function () {

    Route::get('/inventaris/qr/{id}', [InventarisController::class, 'qrcode'])->name('inventaris.qr');
    Route::group(['middleware' => 'auth:api'], function () {
        Route::resource('rak', RakController::class);
        Route::resource('kategori', KategoriController::class);

        Route::get('/inventaris/options', [InventarisController::class, 'options'])->name('inventaris.options');
        Route::get('/inventaris/get-by-qr/{qrcode}', [InventarisController::class, 'getByQrcode'])->name('inventaris.get-by-qr');
        Route::get('/inventaris/not-empty-stock', [InventarisController::class, 'notEmptyStock'])->name('inventaris.not-empty-stock');
        Route::put('/inventaris/{id}/modify-stock', [InventarisController::class, 'modifyStock'])->name('inventaris.not-empty-stock');
        Route::resource('inventaris', InventarisController::class);
    });
});
