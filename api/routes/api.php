<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CinemaHallController;
use App\Http\Controllers\ScreeningController;
use App\Http\Controllers\ReservationController;;


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
    // Route::post('screenings', [ScreeningController::class, 'store']);
    Route::get('screenings/{screening}', [ScreeningController::class, 'show']);
    // Route::put('screenings/{screening}', [ScreeningController::class, 'update']);
    Route::delete('screenings/{screening}', [ScreeningController::class, 'destroy']);
// });

Route::get('screenings/{screening}/reservations', [ReservationController::class, 'screeningIndex']);
// Route::middleware('auth:api')->group(function () {
    Route::get('reservations', [ReservationController::class, 'index']);
    Route::post('reservations', [ReservationController::class, 'store']);
    Route::get('reservations/{reservation}', [ReservationController::class, 'show']);
    // Route::put('reservations/{reservation}', [ReservationController::class, 'update']);
    Route::delete('reservations/{reservation}', [ReservationController::class, 'destroy']);
// });
