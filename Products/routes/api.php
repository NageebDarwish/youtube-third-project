<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/logout', [AuthController::class, 'logout']);
    // Users
    Route::prefix('user')->controller(AuthController::class)->group(function () {
        Route::get('show', 'getAll');
        Route::get('showbyid/{id}', 'getbyId');
        Route::post('update/{id}', 'updateUser');
        Route::post('create', 'register');
        Route::delete('delete/{user_id}', 'remove');
    });
    //  Products
    Route::prefix('product')->controller(ProductsController::class)->group(function () {
        Route::get('show', 'index');
        Route::get('showbyid/{id}', 'getbyId');
        Route::post('update/{id}', 'update');
        Route::post('create', 'create');
        Route::delete('delete/{id}', 'remove');
    });
});


// Public Routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
