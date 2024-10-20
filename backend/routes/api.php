<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ColorsController;
use App\Http\Controllers\DetailProductController;
use App\Http\Controllers\GenderController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SizesController;
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

  // products
  Route::post('/product', [ProductsController::class, 'store']);
  Route::put('/product/{id}', [ProductsController::class, 'update']);
  Route::delete('/product/{id}', [ProductsController::class, 'destroy']);

  // size
  Route::get('/sizes', [SizesController::class, 'index']);
  Route::post('/size', [SizesController::class, 'store']);
  Route::get('/size/{id}', [SizesController::class, 'show']);
  Route::put('/size/{id}', [SizesController::class, 'update']);
  Route::delete('/size/{id}', [SizesController::class, 'destroy']);

  // color
  Route::get('/colors', [ColorsController::class, 'index']);
  Route::get('/color/{id}', [ColorsController::class, 'show']);
  Route::post('/color', [ColorsController::class, 'store']);
  Route::put('/color/{id}', [ColorsController::class, 'update']);
  Route::delete('/color/{id}', [ColorsController::class, 'destroy']);

  // gender
  Route::get('/genders', [GenderController::class, 'index']);
  Route::post('/gender', [GenderController::class, 'store']);
  Route::get('/gender/{id}', [GenderController::class, 'show']);
  Route::put('/gender/{id}', [GenderController::class, 'update']);
  Route::delete('/gender/{id}', [GenderController::class, 'destroy']);
});