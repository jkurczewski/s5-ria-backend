<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdditionController;
use App\Http\Controllers\AlcoholController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeverageController;
use App\Http\Controllers\DrinkController;
use App\Http\Controllers\IngredientsTypes;

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
// Public routes
// Route::get('/register', [AuthController::class, 'register']);
// Route::get('/login', [AuthController::class, 'login']);

Route::get('/additions', [AdditionController::class, 'index']);
Route::get('/additions/{id}', [AdditionController::class, 'show']);

Route::get('/alcohols', [AlcoholController::class, 'index']);
Route::get('/alcohols/{id}', [AlcoholController::class, 'show']);

Route::get('/beverages', [BeverageController::class, 'index']);
Route::get('/beverages/{id}', [BeverageController::class, 'show']);

Route::get('/drinks', [DrinkController::class, 'index']);
Route::get('/drinks/{id}', [DrinkController::class, 'show']);

Route::get('/ingredients', [IngredientsTypes::class, 'index']);

Route::post('/additions', [AdditionController::class, 'store']);
Route::patch('/additions/{id}', [AdditionController::class, 'update']);
Route::delete('/additions/{id}', [AdditionController::class, 'destroy']);

Route::post('/alcohols', [AlcoholController::class, 'store']);
Route::patch('/alcohols/{id}', [AlcoholController::class, 'update']);
Route::delete('/alcohols/{id}', [AlcoholController::class, 'destroy']);

Route::post('/beverages', [BeverageController::class, 'store']);
Route::patch('/beverages/{id}', [BeverageController::class, 'update']);
Route::delete('/beverages/{id}', [BeverageController::class, 'destroy']);

Route::post('/drinks', [DrinkController::class, 'store']);
Route::patch('/drinks/{id}', [DrinkController::class, 'update']);
Route::delete('/drinks/{id}', [DrinkController::class, 'destroy']);

// Private routes
// Route::group(['middleware' => ['auth:sanctum']], function(){
//     Route::get('/logout', [AuthController::class, 'logout']);

//     Route::post('/additions', [AdditionController::class, 'store']);
//     Route::patch('/additions/{id}', [AdditionController::class, 'update']);
//     Route::delete('/additions/{id}', [AdditionController::class, 'destroy']);

//     Route::post('/alcohols', [AlcoholController::class, 'store']);
//     Route::patch('/alcohols/{id}', [AlcoholController::class, 'update']);
//     Route::delete('/alcohols/{id}', [AlcoholController::class, 'destroy']);

//     Route::post('/beverages', [BeverageController::class, 'store']);
//     Route::patch('/beverages/{id}', [BeverageController::class, 'update']);
//     Route::delete('/beverages/{id}', [BeverageController::class, 'destroy']);

//     Route::post('/drinks', [DrinkController::class, 'store']);
//     Route::patch('/drinks/{id}', [DrinkController::class, 'update']);
//     Route::delete('/drinks/{id}', [DrinkController::class, 'destroy']);
// });

