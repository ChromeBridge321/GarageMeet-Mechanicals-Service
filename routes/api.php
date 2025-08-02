<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MechanicalWorkshopController;
use App\Http\Controllers\PositionsController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\VehiclesController;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);


    Route::middleware('api.auth')->group(function () {
        Route::post('me', [AuthController::class, 'me']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::put('update', [AuthController::class, 'updateUser']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

Route::prefix('mechanicals')->group(function () {
    Route::middleware('api.auth')->group(function () {
        Route::post('create', [MechanicalWorkshopController::class, 'create']);
        Route::put('update', [MechanicalWorkshopController::class, 'update']);
    });
});


Route::prefix('positions')->group(function () {
    Route::middleware('api.auth')->group(function () {
        Route::post('create', [PositionsController::class, 'create']);
        Route::put('update', [PositionsController::class, 'update']);
        Route::delete('delete', [PositionsController::class, 'delete']);
        Route::get('all', [PositionsController::class, 'getAll']);
        Route::get('getById', [PositionsController::class, 'getById']);
    });
});

Route::prefix('employees')->group(function () {
    Route::middleware('api.auth')->group(function () {
        Route::post('create', [EmployeesController::class, 'create']);
        Route::put('update', [EmployeesController::class, 'update']);
        Route::delete('delete', [EmployeesController::class, 'delete']);
        Route::get('all', [EmployeesController::class, 'getAll']);
        Route::get('getById', [EmployeesController::class, 'getById']);
    });
});

Route::prefix('clients')->group(function () {
    Route::middleware('api.auth')->group(function () {
        Route::post('create', [ClientsController::class, 'create']);
        Route::put('update', [ClientsController::class, 'update']);
        Route::delete('delete', [ClientsController::class, 'delete']);
        Route::get('all', [ClientsController::class, 'getAll']);
        Route::get('getById', [ClientsController::class, 'getById']);
    });
});


Route::prefix('vehiclesService')->group(function () {
    Route::middleware('api.auth')->group(function () {
        Route::get('getAllModels', [VehiclesController::class, 'getAllModels']);
        Route::get('getAllMakes', [VehiclesController::class, 'getAllMakes']);
        Route::get('getModelByName', [VehiclesController::class, 'getModelByName']);
        Route::get('getMakeByName', [VehiclesController::class, 'getMakeByName']);
        Route::get('getModelsByMakeId/{makeId}', [VehiclesController::class, 'getModelsByMakeId']);
        Route::get('getMMByMMID/{makesModelId}', [VehiclesController::class, 'getModelMakeByMakesModelId']);
    });
});

Route::prefix('payment-methods')->group(function () {
    Route::middleware('api.auth')->group(function () {
        Route::post('setup-intent', [PaymentMethodController::class, 'createSetupIntent']);
        Route::post('attach', [PaymentMethodController::class, 'attachPaymentMethod']);
        Route::get('list', [PaymentMethodController::class, 'getPaymentMethods']);
        Route::delete('delete', [PaymentMethodController::class, 'deletePaymentMethod']);
    });
});
