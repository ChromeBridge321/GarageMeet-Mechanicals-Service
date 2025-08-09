<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\MechanicalWorkshopController;
use App\Http\Controllers\PositionsController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PaymentTypesContoller;
use App\Http\Controllers\PiecesController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\VehiclesController;
use Illuminate\Support\Facades\Route;

Route::prefix('cities')->group(function () {
    Route::get('findByName/{name}', [CitiesController::class, 'findByName']);
});

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
    Route::get('all', [MechanicalWorkshopController::class, 'getAll']);
    Route::get('getByState/{state}', [MechanicalWorkshopController::class, 'getAllWorkshopsByState']);
    Route::get('getByStateAndCity/{state}/{city}', [MechanicalWorkshopController::class, 'getAllWorkshopsByStateAndCity']);
    Route::middleware('api.auth')->group(function () {
        Route::post('create', [MechanicalWorkshopController::class, 'create']);
        Route::put('update', [MechanicalWorkshopController::class, 'update']);
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

Route::prefix('positions')->group(function () {
    Route::middleware('api.auth')->group(function () {
        Route::get('all', [PositionsController::class, 'getAll']);
        Route::get('getById', [PositionsController::class, 'getById']);
    });
});


Route::prefix('employees')->group(function () {
    Route::middleware('api.auth')->group(function () {
        Route::get('all', [EmployeesController::class, 'getAll']);
        Route::get('getById', [EmployeesController::class, 'getById']);
    });
});

Route::prefix('clients')->group(function () {
    Route::middleware('api.auth')->group(function () {
        Route::get('all', [ClientsController::class, 'getAll']);
        Route::get('getById', [ClientsController::class, 'getById']);
    });
});
// Rutas públicas de suscripciones
Route::get('/subscription-plans', [SubscriptionController::class, 'getPlans']);

// Rutas protegidas por autenticación
Route::middleware(['auth:api'])->group(function () {
    // Suscripciones
    Route::prefix('subscriptions')->group(function () {
        Route::post('create', [SubscriptionController::class, 'createSubscription']);
        Route::get('status', [SubscriptionController::class, 'getSubscriptionStatus']);
        Route::post('cancel', [SubscriptionController::class, 'cancelSubscription']);
        Route::post('resume', [SubscriptionController::class, 'resumeSubscription']);
    });

    Route::prefix('services')->group(function () {
        Route::get('all', [ServicesController::class, 'getAll']);
    });

    Route::prefix('payment-types')->group(function () {
        Route::get('all', [PaymentTypesContoller::class, 'getAll']);
    });

    Route::prefix('pieces')->group(function () {
        Route::get('all', [PiecesController::class, 'getAll']);
    });



    // Rutas que requieren suscripción activa
    Route::middleware(['check.subscription'])->group(function () {
        // Aquí van todas las rutas del dashboard que requieren suscripción
        Route::prefix('dashboard')->group(function () {
            // Servicios del taller
            Route::prefix('services')->group(function () {
                Route::post('create', [ServicesController::class, 'create']);
                Route::get('getById', [ServicesController::class, 'getById']);
                Route::put('update', [ServicesController::class, 'update']);
                Route::delete('delete', [ServicesController::class, 'delete']);
            });

            // Tipos de pago del taller
            Route::prefix('payment-types')->group(function () {
                Route::post('create', [PaymentTypesContoller::class, 'create']);
                Route::get('getById', [PaymentTypesContoller::class, 'getById']);
                Route::put('update', [PaymentTypesContoller::class, 'update']);
                Route::delete('delete', [PaymentTypesContoller::class, 'delete']);
            });

            // Piezas del taller
            Route::prefix('pieces')->group(function () {
                Route::post('create', [PiecesController::class, 'create']);
                Route::get('getById', [PiecesController::class, 'getById']);
                Route::put('update', [PiecesController::class, 'update']);
                Route::delete('delete', [PiecesController::class, 'delete']);
            });

            Route::prefix('positions')->group(function () {
                Route::middleware('api.auth')->group(function () {
                    Route::post('create', [PositionsController::class, 'create']);
                    Route::put('update', [PositionsController::class, 'update']);
                    Route::delete('delete', [PositionsController::class, 'delete']);
                });
            });

            Route::prefix('employees')->group(function () {
                Route::middleware('api.auth')->group(function () {
                    Route::post('create', [EmployeesController::class, 'create']);
                    Route::put('update', [EmployeesController::class, 'update']);
                    Route::delete('delete', [EmployeesController::class, 'delete']);
                });
            });

            Route::prefix('clients')->group(function () {
                Route::middleware('api.auth')->group(function () {
                    Route::post('create', [ClientsController::class, 'create']);
                    Route::put('update', [ClientsController::class, 'update']);
                    Route::delete('delete', [ClientsController::class, 'delete']);
                });
            });
            Route::prefix('sales')->group(function () {
                Route::middleware('api.auth')->group(function () {
                    Route::post('create', [SaleController::class, 'create']);
                    Route::put('update', [SaleController::class, 'update']);
                    Route::delete('delete', [SaleController::class, 'delete']);
                    Route::get('getById', [SaleController::class, 'getById']);
                });
            });
        });
    });
});
