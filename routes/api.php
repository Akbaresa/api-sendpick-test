<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\JobOrderController;

Route::post('/auth/login', [AuthController::class, 'login'])->middleware('guest');

Route::middleware('auth.bearer.admin')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/job-orders', [JobOrderController::class, 'index']);
});
