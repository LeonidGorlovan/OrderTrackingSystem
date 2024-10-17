<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RegistrationController;
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

Route::post('/registration', RegistrationController::class);
Route::post('/auth/create-token', [AuthController::class, 'createToken']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/clear-token', [AuthController::class, 'clearCurrentAccessToken']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('/order', OrderController::class);
});
