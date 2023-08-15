<?php

use App\Http\Controllers\API\UserAuthController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register', [UserAuthController::class, 'register']);
Route::post('login', [UserAuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('logout', [UserAuthController::class, 'logout']);
    Route::get('profile', [UserAuthController::class, 'profile']);
    Route::post('change-password', [UserAuthController::class, 'changePassword']);
    Route::post('profile-update', [UserAuthController::class, 'profileUpdate']);

    Route::apiResource('user', UserController::class);
});
