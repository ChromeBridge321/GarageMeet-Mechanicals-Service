<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\TestController;

Route::get('/', function () {
    return view('emails.appointment-new-request-client');
});

// Ruta pública para cancelar citas por token
Route::get('/appointments/cancel/{token}', [AppointmentController::class, 'cancelByToken']);

// Rutas de prueba (temporales)
Route::get('/test/email', [TestController::class, 'testEmail']);
Route::get('/test/appointment', [TestController::class, 'testAppointment']);
