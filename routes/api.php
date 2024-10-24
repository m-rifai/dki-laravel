<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\LocationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', function (Request $request) {
            return new UserResource($request->user());
        });

        Route::prefix('locations')->group(function () {
            Route::get('/provinces', [LocationController::class, 'getProvinces']);
            Route::get('/cities/{province}', [LocationController::class, 'getCities']);
            Route::get('/districts/{city}', [LocationController::class, 'getDistricts']);
            Route::get('/villages/{district}', [LocationController::class, 'getVillages']);
        });
    });
});
