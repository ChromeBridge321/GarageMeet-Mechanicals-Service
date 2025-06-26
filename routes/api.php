<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MechanicalWorkshopController;
use App\Http\Controllers\PositionsController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\ClientsController;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);


    Route::middleware('api.auth')->group(function () {
        Route::post('me', [AuthController::class, 'me']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

Route::prefix('mechanicals')->group(function () {
    Route::middleware('api.auth')->group(function () {
        Route::post('create', [MechanicalWorkshopController::class, 'create']);
        Route::post('update', [MechanicalWorkshopController::class, 'update']);
    });
});


Route::prefix('positions')->group(function () {
    Route::middleware('api.auth')->group(function () {
        Route::post('create', [PositionsController::class, 'create']);
        Route::post('update', [PositionsController::class, 'update']);
        Route::delete('delete', [PositionsController::class, 'delete']);
        Route::get('all', [PositionsController::class, 'getAll']);
    });
});

Route::prefix('employees')->group(function () {
    Route::middleware('api.auth')->group(function () {
        Route::post('create', [EmployeesController::class, 'create']);
        Route::post('update', [EmployeesController::class, 'update']);
        Route::delete('delete', [EmployeesController::class, 'delete']);
        Route::get('all', [EmployeesController::class, 'getAll']);

    });
});

Route::prefix('clients')->group(function () {
    Route::middleware('api.auth')->group(function () {
        Route::post('create', [ClientsController::class, 'create']);
        Route::post('update', [ClientsController::class, 'update']);
        Route::delete('delete', [ClientsController::class, 'delete']);
        Route::get('all', [ClientsController::class, 'getAll']);
    });
});
