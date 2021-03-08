<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Jobs\MyJobsController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AuthUserController;



Route::post('login', LoginController::class);
Route::post('register', RegisterController::class);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', LogoutController::class);

    Route::get('user', AuthUserController::class);

    Route::apiResource('my/jobs', MyJobsController::class);
});
