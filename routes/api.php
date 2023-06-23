<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiAuthController;

Route::post('login', [ApiAuthController::class, 'login']);
Route::post('signup', [ApiAuthController::class, 'signup']);

Route::middleware('auth:sanctum')->group(function () {
    Route::any('logout', [ApiAuthController::class, 'logout']);
});
