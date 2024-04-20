<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CinemaHallController;
use App\Http\Controllers\ScreeningController;


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

Route::get('cinema_halls', [CinemaHallController::class, 'index']);
// Route::middleware('auth:api')->group(function () {
    Route::post('cinema_halls', [CinemaHallController::class, 'store']);
    Route::get('cinema_halls/{cinema_hall}', [CinemaHallController::class, 'show']);
    Route::put('cinema_halls/{cinema_hall}', [CinemaHallController::class, 'update']);
    Route::delete('cinema_halls/{cinema_hall}', [CinemaHallController::class, 'destroy']);
// });

Route::get('cinema_halls/{cinema_hall}/screenings', [ScreeningController::class, 'cinemaHallIndex']);

// Route::middleware('auth:api')->group(function () {
    Route::get('screenings', [ScreeningController::class, 'index']);
    Route::post('screenings', [ScreeningController::class, 'store']);
    Route::get('screenings/{cinema_hall}', [ScreeningController::class, 'show']);
    Route::put('screenings/{cinema_hall}', [ScreeningController::class, 'update']);
    Route::delete('screenings/{cinema_hall}', [ScreeningController::class, 'destroy']);
// });
