<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\socialAuthController;
use App\Http\Controllers\UsersContoller;
use Illuminate\Http\Request;
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


// Public Routes
Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

// Protected Routes
Route::middleware('auth:api')->group(function () {
    Route::get('/users', [UsersContoller::class, 'GetUsers']);
    Route::get('/logout', [AuthController::class, 'logout']);
});

Route::get('/login-google', [socialAuthController::class, 'redirectToProvider']);
Route::get('/auth/google/callback', [socialAuthController::class, 'handleCallback']);
