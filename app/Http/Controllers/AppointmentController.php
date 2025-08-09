<?php

namespace App\Http\Controllers;

use App\Contracts\Services\AppointmentServiceInterface;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    private AppointmentServiceInterface $appointmentService;

    public function __construct(AppointmentServiceInterface $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    /**
     * Crear nueva solicitud de cita (desde la app móvil)
     */
    public function createRequest(StoreAppointmentRequest $request)
    {
        try {
            $data = $request->validated();
            $appointment = $this->appointmentService->createAppointmentRequest($data);

            return ApiResponse::created(
                'Solicitud de cita creada exitosamente. Te notificaremos cuando sea confirmada.',
                $appointment
            );
        } catch (\Exception $e) {
            return ApiResponse::error('Error al crear la solicitud de cita', $e->getMessage());
        }
    }

    /**
     * Confirmar cita (desde el dashboard del taller)
     */
    public function confirm(Request $request)
    {
        try {
            $data = $request->validate([
                'appointment_id' => 'required|exists:appointments,appointment_id',
                'confirmed_date' => 'required|date|after:now',
                'confirmed_time' => 'required|date_format:H:i:s',
                'notes' => 'sometimes|string|max:1000'
            ]);

            $appointment = $this->appointmentService->confirmAppointment($data);

            return ApiResponse::success('Cita confirmada exitosamente', $appointment);
        } catch (\Exception $e) {
            return ApiResponse::error('Error al confirmar la cita', $e->getMessage());
        }
    }

    /**
     * Obtener todas las citas de un taller específico
     */
    public function getAllByWorkshop(Request $request)
    {
        try {
            $workshopId = $request->mechanical_workshops_id;
            $appointments = $this->appointmentService->getAllAppointments($workshopId);

            return ApiResponse::success('Citas obtenidas exitosamente', $appointments);
        } catch (\Exception $e) {
            return ApiResponse::error('Error al obtener las citas', $e->getMessage());
        }
    }

    /**
     * Obtener todas las citas de un taller
     */

    /**
     * Obtener cita por ID
     */
    public function getById(Request $request)
    {
        try {
            $data = $request->validate([
                'appointment_id' => 'required|exists:appointments,appointment_id'
            ]);

            $appointment = $this->appointmentService->getAppointmentById($data['appointment_id']);

            if (!$appointment) {
                return ApiResponse::notFound('Cita no encontrada');
            }

            return ApiResponse::success('Cita obtenida exitosamente', $appointment);
        } catch (\Exception $e) {
            return ApiResponse::error('Error al obtener la cita', $e->getMessage());
        }
    }

    /**
     * Cancelar cita (desde dashboard)
     */
    public function cancel(Request $request)
    {
        try {
            $data = $request->validate([
                'appointment_id' => 'required|exists:appointments,appointment_id'
            ]);

            $appointment = $this->appointmentService->cancelAppointment($data['appointment_id']);

            return ApiResponse::success('Cita cancelada exitosamente', $appointment);
        } catch (\Exception $e) {
            return ApiResponse::error('Error al cancelar la cita', $e->getMessage());
        }
    }

    /**
     * Cancelar cita por token público (desde email)
     */
    public function cancelByToken(Request $request, string $token)
    {
        try {
            $appointment = $this->appointmentService->cancelAppointmentByToken($token);

            // Retornar vista de confirmación de cancelación
            return view('appointments.cancelled', compact('appointment'));
        } catch (\Exception $e) {
            return view('appointments.error', ['message' => $e->getMessage()]);
        }
    }

    /**
     * Enviar recordatorio de cita
     */
    public function sendReminder(Request $request)
    {
        try {
            $data = $request->validate([
                'appointment_id' => 'required|exists:appointments,appointment_id'
            ]);

            $this->appointmentService->sendReminder($data['appointment_id']);

            return ApiResponse::success('Recordatorio enviado exitosamente');
        } catch (\Exception $e) {
            return ApiResponse::error('Error al enviar recordatorio', $e->getMessage());
        }
    }

    /**
     * Marcar cita como completada
     */
    public function markAsCompleted(Request $request)
    {
        try {
            $data = $request->validate([
                'appointment_id' => 'required|exists:appointments,appointment_id',
                'notes' => 'sometimes|string|max:1000'
            ]);

            // Actualizar directamente el repositorio para marcar como completada
            $appointment = $this->appointmentService->getAppointmentById($data['appointment_id']);

            if (!$appointment) {
                return ApiResponse::notFound('Cita no encontrada');
            }

            // Aquí podrías agregar lógica adicional para marcar como completada

            return ApiResponse::success('Cita marcada como completada', $appointment);
        } catch (\Exception $e) {
            return ApiResponse::error('Error al completar la cita', $e->getMessage());
        }
    }
}
