<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestingUserController;

Route::prefix('testing_users')->group(function () {
    Route::get('/', [TestingUserController::class, 'index']);
    Route::post('/', [TestingUserController::class, 'store']);
    Route::get('/{testing_user}', [TestingUserController::class, 'show']);
    Route::put('/{testing_user}', [TestingUserController::class, 'update']);
    Route::delete('/{testing_user}', [TestingUserController::class, 'destroy']);
    Route::post('/bulk-delete', [TestingUserController::class, 'bulkDelete']);
    Route::get('/export', [TestingUserController::class, 'exportExcel']);
});
