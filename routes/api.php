<?php

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

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;

Route::middleware('auth:sanctum')->get('/my-profile', function (Request $request) {
    return $request->user()->only([
        'name', 'email', 'username'
    ]);
});

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/clients', [ClientController::class, 'index']);
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
});
