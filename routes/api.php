<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\JobOrderController;

Route::post('/auth/login', [AuthController::class, 'login'])->middleware('guest');

Route::middleware('auth.bearer.admin')->group(function () {
    Route::prefix('auth')->group(function(){
        Route::post('/me', [AuthController::class, 'me']);
    });
    Route::prefix('job-orders')->group(function(){
        Route::get('/', [JobOrderController::class, 'index']);
        Route::get('/{id}', [JobOrderController::class, 'show']);
    });
});
