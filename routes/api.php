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



Route::post('/v1/auth/login', [AuthController::class, 'login']);
Route::post('/v1/auth/register', [AuthController::class, 'register']);
Route::post('/v1/auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
// Route Private (Harus Login / Punya Token)
Route::middleware('auth:sanctum')->group(function () {
    

    // User Profile Routes
    Route::get('/v1/user/profile', [UserController::class, 'show']);
    Route::post('/v1/user/profile', [UserController::class, 'update']);

    // Resource Routes
    Route::apiResource('v1/users', UserController::class);
    Route::apiResource('v1/emission/categories', EmissionCategoryController::class);
    Route::apiResource('v1/emission/factors', EmissionFactorController::class);
    Route::apiResource('v1/consumption/entries', ConsumptionEntryController::class);

    
});


