<?php

use App\Http\Controllers\Api\V1\AiInfoController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\DashboardController;
use App\Http\Controllers\Api\V1\DiagnosisController;
use App\Http\Controllers\Api\V1\PatientProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API V1 Routes - Dr. Hakeem Medical AI System (Skin Diagnosis API)
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {

    // 1. Authentication Endpoints
    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::get('/profile', [AuthController::class, 'profile']);
        });
    });

    // 2. Patient Profile & Settings Endpoints (Protected)
    Route::middleware('auth:sanctum')->prefix('patient')->group(function () {
        Route::get('/profile', [PatientProfileController::class, 'profile']);
        Route::put('/settings', [PatientProfileController::class, 'updateSettings']);
    });

    // 3. AI Scan & Diagnoses Endpoints (Protected)
    Route::middleware('auth:sanctum')->group(function () {
        // Standard Dr. Hakeem Diagnosis Endpoints
        Route::post('/diagnoses/process', [DiagnosisController::class, 'process']);
        Route::get('/diagnoses/history', [DiagnosisController::class, 'history']);
        Route::get('/diagnoses/{diagnosis}', [DiagnosisController::class, 'show']);
        Route::delete('/diagnoses/{diagnosis}', [DiagnosisController::class, 'destroy']);

        // Backwards Compatible Endpoints
        Route::post('/scans', [DiagnosisController::class, 'store']);
        Route::get('/scans', [DiagnosisController::class, 'index']);
        Route::get('/scans/{diagnosis}', [DiagnosisController::class, 'show']);
        Route::delete('/scans/{diagnosis}', [DiagnosisController::class, 'destroy']);
    });

    // 4. Dashboard & Analytics Endpoints (Protected)
    Route::middleware('auth:sanctum')->prefix('dashboard')->group(function () {
        Route::get('/stats', [DashboardController::class, 'stats']);
    });

    // 5. External AI Model Info (Public)
    Route::get('/ai/info', [AiInfoController::class, 'info']);

});
