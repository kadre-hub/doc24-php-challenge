<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MedicalTurnsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Auth.
Route::group(['middleware' => 'api'], function () {
    // Auth.
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('me', [AuthController::class, 'me']);
    });

    // Medical turns.
    Route::group(['prefix' => 'medical-turns'], function () {
        Route::get('', [MedicalTurnsController::class, 'getAll']);
        Route::get('/{id}', [MedicalTurnsController::class, 'getById']);

        Route::post('', [MedicalTurnsController::class, 'add']);

        Route::put('/{id}', [MedicalTurnsController::class, 'update']);

        Route::delete('/{id}', [MedicalTurnsController::class, 'delete']);
    });
});
