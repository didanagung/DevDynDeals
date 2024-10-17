<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DetailProductController;
use App\Http\Controllers\ProductsController;
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

// auth
Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/register', [AuthenticationController::class, 'store']);

// products user
Route::get('/products', [ProductsController::class, 'index']);
Route::get('/product/{id}', [ProductsController::class, 'show']);

Route::middleware(['auth:sanctum'])->group(function () {
  // auth
  Route::get('/logout', [AuthenticationController::class, 'logout']);
  Route::post('/product', [ProductsController::class, 'store']);
  Route::put('/product/{id}', [ProductsController::class, 'update']);
  Route::delete('/product/{id}', [ProductsController::class, 'destroy']);
});