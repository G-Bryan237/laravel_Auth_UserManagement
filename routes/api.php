<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\RegionController;
use App\Http\Controllers\Admin\ManagerController;
use App\Http\Controllers\Admin\CaseManagerController;
use App\Http\Controllers\Admin\SchoolController;
use App\Http\Controllers\Admin\SchoolClassController;
use App\Http\Controllers\Admin\SpecialtyController;

// Admin Routes
Route::prefix('admin')->group(function () {
    // Public admin routes
    Route::post('/register-start', [AdminController::class, 'registerStart']);
    Route::post('/login', [AdminController::class, 'login']);
    Route::get('/dropdown-data', [AdminController::class, 'getDropdownData']);
    
    // Protected admin routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/register-next', [AdminController::class, 'registerNext']);
        Route::get('/profile', [AdminController::class, 'profile']);
        Route::post('/logout', [AdminController::class, 'logout']);
    });
});

// User Routes
Route::prefix('user')->group(function () {
    // Public user routes
    Route::post('/register-start', [UserController::class, 'registerStart']);
    Route::post('/login', [UserController::class, 'login']);
    
    // Protected user routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/register-next', [UserController::class, 'registerNext']);
        Route::get('/profile', [UserController::class, 'profile']);
        Route::post('/logout', [UserController::class, 'logout']);
    });
});

// Admin protected resources
Route::prefix('admin')->middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('countries', CountryController::class);
    Route::apiResource('regions', RegionController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('managers', ManagerController::class);
    Route::apiResource('case-managers', CaseManagerController::class);
    Route::apiResource('schools', SchoolController::class);
    Route::apiResource('classes', SchoolClassController::class);
    Route::apiResource('specialties', SpecialtyController::class);
});

//Duplicate
// Admin Registration Routes
// Route::prefix('admin')->group(function () {
//     Route::post('/register/start', [AdminController::class, 'registerStart']);
//     Route::post('/register/next', [AdminController::class, 'registerNext'])->middleware('auth:sanctum');
//     Route::get('/dropdown-data', [AdminController::class, 'getDropdownData']);
// });

// Test Database Connection
Route::get('/test-db', [App\Http\Controllers\DatabaseTestController::class, 'testConnection']);
