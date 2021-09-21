<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/welcome', function () {
    return "welcome to API";
});

Route::group(['middleware'=>'api'], function () {
    
    Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);
    Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register']);
    
    Route::get('/refresh_token', [App\Http\Controllers\Api\AuthController::class, 'refresh_token']);
    Route::get('/profile', [App\Http\Controllers\Api\AuthController::class, 'profile']);
    Route::get('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);

    Route::group(['prefix'=>'product'], function () {
        Route::get('/list', [App\Http\Controllers\Api\ProductController::class, 'index']);
        Route::post('/add', [App\Http\Controllers\Api\ProductController::class, 'create']);
        Route::get('/show/{id}', [App\Http\Controllers\Api\ProductController::class, 'show']);
        Route::get('/edit/{id}', [App\Http\Controllers\Api\ProductController::class, 'edit']);
        Route::put('/update/{id}', [App\Http\Controllers\Api\ProductController::class, 'update']);
        Route::delete('/delete/{id}', [App\Http\Controllers\Api\ProductController::class, 'destroy']);
    });
});