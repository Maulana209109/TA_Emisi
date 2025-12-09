<?php

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

// Import Controller dari Namespace Baru (Api)
use App\Http\Controllers\Api\UserController;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Api\EmissionFactorController;
use App\Http\Controllers\Api\ConsumptionEntryController;
use App\Http\Controllers\Api\EmissionCategoryController;



Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
// Route Private (Harus Login / Punya Token)
Route::middleware('auth:sanctum')->group(function () {
    

    // User Profile Routes
    Route::get('/user/profile', [UserController::class, 'show']);
    Route::post('/user/profile', [UserController::class, 'update']);

    // Resource Routes
    Route::apiResource('users', UserController::class);
    Route::apiResource('emission/categories', EmissionCategoryController::class);
    Route::apiResource('emission/factors', EmissionFactorController::class);
    Route::apiResource('consumption/entries', ConsumptionEntryController::class);
});


