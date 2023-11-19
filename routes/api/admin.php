<?php

use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\PaymentController;
use App\Http\Controllers\Api\Admin\ReportController;
use App\Http\Controllers\Api\Admin\TransactionController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {

    Route::middleware('auth:admin')->group(function () {
        Route::apiResources([
            'transactions' => TransactionController::class,
            'payments' => PaymentController::class,
        ]);

        Route::get('reports/transactions', [ReportController::class, 'transactions']);
    });
    Route::post('login', [AuthController::class, 'login']);
});

