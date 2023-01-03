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

// Public Routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


// Users

Route::prefix('user')->controller(AuthController::class)->group(function () {
    Route::get('show', 'getAll');
    Route::get('showbyid/{id}', 'getbyId');
    Route::post('update/{id}', 'updateUser');
    Route::delete('delete/{user_id}', 'remove');
});

// Products

Route::prefix('product')->controller(ProductsController::class)->group(function () {
    Route::post('create', 'create');
    Route::get('show', 'index');
    Route::get('showbyid/{id}', 'getbyId');
    Route::delete('delete/{id}', 'destroy');
});



// Protected Routes

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('/logout', [AuthController::class, 'logout']);
});
