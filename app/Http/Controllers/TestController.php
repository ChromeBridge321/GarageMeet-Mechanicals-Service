<?php

namespace App\Http\Controllers;

use App\Contracts\Services\AppointmentServiceInterface;
use App\Mail\AppointmentNotification;
use App\Models\Appointments;
use App\Models\Mechanicals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    /**
     * Test de creación de cita
     */
    public function testAppointment(AppointmentServiceInterface $appointmentService)
    {
        try {
            Log::info('=== STARTING APPOINTMENT TEST ===');

            // Obtener el primer taller
            $workshop = Mechanicals::first();

            Log::info('Workshop found:', $workshop ? $workshop->toArray() : ['result' => 'NULL']);

            if (!$workshop) {
                return response()->json(['error' => 'No hay talleres registrados']);
            }

            // Verificar que el taller tenga email
            if (!$workshop->email) {
                Log::warning('Workshop has no email configured');
                return response()->json([
                    'error' => 'El taller no tiene email configurado',
                    'workshop' => $workshop->toArray()
                ]);
            }

            // Datos de prueba
            $data = [
                'mechanical_workshops_id' => $workshop->id,
                'client_name' => 'Juan Pérez',
                'client_email' => 'test@example.com',
                'client_phone' => '+505 8888-8888',
                'description' => 'Mi carro hace un ruido extraño en el motor cuando acelero.',
                'created_by' => 'app'
            ];

            Log::info('Creating appointment with data:', $data);

            // Crear cita
            $appointment = $appointmentService->createAppointmentRequest($data);

            Log::info('Appointment created successfully:', $appointment);

            return response()->json([
                'message' => 'Cita creada exitosamente',
                'appointment' => $appointment,
                'workshop_email' => $workshop->email
            ]);

        } catch (\Exception $e) {
            Log::error('Error in testAppointment: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'error' => 'Error al crear cita',
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }    /**
     * Test de envío de email
     */
    public function testEmail()
    {
        try {
            Mail::raw('Este es un email de prueba desde GarageMeet', function ($message) {
                $message->to('test@example.com')
                        ->subject('Test Email - GarageMeet');
            });

            return response()->json(['message' => 'Email enviado exitosamente']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al enviar email',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
