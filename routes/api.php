<?php

use App\Http\Controllers\Api\V1\AiInfoController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\DiagnosisController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API V1 Routes - Skin Disease Diagnosis AI Service
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {

    // Authentication Endpoints
    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::get('/profile', [AuthController::class, 'profile']);
        });
    });

    // AI External Model Operational Status Info
    Route::get('/ai/info', [AiInfoController::class, 'info']);

    // Skin Scan Diagnoses Endpoints (Protected)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/scans', [DiagnosisController::class, 'store']);
        Route::get('/scans', [DiagnosisController::class, 'index']);
        Route::get('/scans/{diagnosis}', [DiagnosisController::class, 'show']);
        Route::delete('/scans/{diagnosis}', [DiagnosisController::class, 'destroy']);
    });

});
