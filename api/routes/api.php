<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CinemaHallController;


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

// Route::middleware('auth:api')->group(function () {
    Route::get('cinema_halls', [CinemaHallController::class, 'index']);
    Route::post('cinema_halls', [CinemaHallController::class, 'store']);
    Route::get('cinema_halls/{cinema_hall}', [CinemaHallController::class, 'show']);
    Route::put('cinema_halls/{cinema_hall}', [CinemaHallController::class, 'update']);
    Route::delete('cinema_halls/{cinema_hall}', [CinemaHallController::class, 'destroy']);
// });
