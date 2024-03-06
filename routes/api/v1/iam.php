<?php

use App\Modules\Iam\Controllers\RoleController;
use App\Modules\Iam\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'iam', 'as' => 'iam.',
], function () {
    Route::resource('role', RoleController::class);
    Route::resource('user', UserController::class);
    Route::post('/user/{userId}/change-avatar', [UserController::class, 'changeAvatar'])->name('user.change-avatar');
});
