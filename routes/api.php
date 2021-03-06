<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Jobs\JobsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Jobs\MyJobsController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AuthUserController;
use App\Http\Controllers\Jobs\JobApplicationsController;

Route::post('login', LoginController::class);

Route::post('register', RegisterController::class);

Route::apiResource('jobs', JobsController::class)->only(['index', 'show']);

Route::apiResource('jobs.apply', JobApplicationsController::class)->only(['store']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', LogoutController::class);

    Route::get('user', AuthUserController::class);

    Route::apiResource('my/jobs', MyJobsController::class);

    Route::apiResource('my/jobs.applications', JobApplicationsController::class)
        ->only(['index']);
});
