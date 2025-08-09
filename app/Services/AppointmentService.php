<?php

namespace App\Services;

use App\Contracts\Repositories\AppointmentRepositoryInterface;
use App\Contracts\Services\AppointmentServiceInterface;
use App\Mail\AppointmentNotification;
use App\Models\Appointments;
use App\Models\Mechanicals;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AppointmentService implements AppointmentServiceInterface
{
    private AppointmentRepositoryInterface $repository;

    public function __construct(AppointmentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function createAppointmentRequest(array $data): array
    {
        return DB::transaction(function () use ($data) {
            // Crear la solicitud de cita
            $appointmentData = [
                'mechanical_workshops_id' => $data['mechanical_workshops_id'],
                'client_name' => $data['client_name'],
                'client_email' => $data['client_email'],
                'client_phone' => $data['client_phone'],
                'description' => $data['description'],
                'status' => 'pending',
                'created_by' => $data['created_by'] ?? 'app'
            ];

            $appointment = $this->repository->create($appointmentData);

            // Enviar notificación al taller
            $this->sendNotificationToWorkshop($appointment, 'new_request');

            // Enviar notificación al cliente
            $this->sendNotificationToClient($appointment, 'new_request_client');

            return $appointment;
        });
    }

    public function confirmAppointment(array $data): array
    {
        return DB::transaction(function () use ($data) {
            // Validar que el ID de la cita esté presente
            if (!isset($data['appointment_id'])) {
                throw new \InvalidArgumentException('El ID de la cita es requerido');
            }

            $appointmentId = $data['appointment_id'];

            // Actualizar la cita con fecha y status confirmado
            $updateData = [
                'confirmed_date' => $data['confirmed_date'],
                'confirmed_time' => $data['confirmed_time'],
                'status' => 'confirmed',
                'notes' => $data['notes'] ?? null
            ];

            $this->repository->update($appointmentId, $updateData);
            $appointment = $this->repository->findById($appointmentId);

            // Enviar notificación al cliente
            $this->sendNotificationToClient($appointment, 'confirmed');

            return $appointment;
        });
    }

    public function cancelAppointment(int $id): array
    {
        return DB::transaction(function () use ($id) {
            $appointment = $this->repository->findById($id);

            if (!$appointment) {
                throw new \Exception('Cita no encontrada');
            }

            // Actualizar status a cancelado
            $this->repository->update($id, ['status' => 'cancelled']);
            $appointment = $this->repository->findById($id);

            // Enviar notificación al cliente
            $this->sendNotificationToClient($appointment, 'cancelled');

            return $appointment;
        });
    }

    public function cancelAppointmentByToken(string $token): array
    {
        return DB::transaction(function () use ($token) {
            $appointment = $this->repository->findByToken($token);

            if (!$appointment) {
                throw new \Exception('Token de cancelación inválido');
            }

            if ($appointment['status'] === 'cancelled') {
                throw new \Exception('La cita ya ha sido cancelada');
            }

            // Actualizar status a cancelado
            $this->repository->update($appointment['appointment_id'], ['status' => 'cancelled']);
            $appointment = $this->repository->findById($appointment['appointment_id']);

            // Enviar notificación de confirmación de cancelación
            $this->sendNotificationToClient($appointment, 'cancelled');

            return $appointment;
        });
    }

    public function getAllAppointments(int $workshopId, array $filters = []): array
    {
        return $this->repository->getAllByWorkshop($workshopId, $filters);
    }

    public function getAppointmentById(int $id): ?array
    {
        return $this->repository->findById($id);
    }

    public function sendReminder(int $id): void
    {
        $appointment = $this->repository->findById($id);

        if ($appointment && $appointment['status'] === 'confirmed') {
            $this->sendNotificationToClient($appointment, 'reminder');
        }
    }

    /**
     * Enviar notificación al taller
     */
    private function sendNotificationToWorkshop(array $appointment, string $type): void
    {
        try {
            Log::info('=== STARTING WORKSHOP NOTIFICATION ===');
            Log::info('Appointment data received:', [
                'appointment_id' => $appointment['appointment_id'] ?? 'NULL',
                'mechanical_workshops_id' => $appointment['mechanical_workshops_id'] ?? 'NULL',
                'workshop_data' => $appointment['workshop'] ?? 'NULL',
                'type' => $type
            ]);

            // Buscar el taller directamente por ID
            $workshop = Mechanicals::find($appointment['mechanical_workshops_id']);

            Log::info('Workshop found:', $workshop ? $workshop->toArray() : ['result' => 'NULL']);

            if ($workshop && $workshop->email) {
                Log::info('Workshop email found: ' . $workshop->email);

                // Buscar el appointment model
                $appointmentModel = Appointments::find($appointment['appointment_id']);

                if ($appointmentModel) {
                    Log::info('Appointment model loaded successfully');

                    // Cargar la relación workshop
                    $appointmentModel->load('workshop');

                    Log::info('About to send email to workshop: ' . $workshop->email);

                    Mail::to($workshop->email)->send(
                        new AppointmentNotification($appointmentModel, $type)
                    );

                    Log::info('✅ Email sent successfully to workshop: ' . $workshop->email);
                } else {
                    Log::error('❌ Appointment model not found with ID: ' . $appointment['appointment_id']);
                }
            } else {
                Log::warning('❌ Workshop not found or no email configured', [
                    'workshop_found' => $workshop ? 'YES' : 'NO',
                    'email' => $workshop->email ?? 'NULL'
                ]);
            }

            Log::info('=== WORKSHOP NOTIFICATION COMPLETED ===');
        } catch (\Exception $e) {
            Log::error('❌ ERROR in sendNotificationToWorkshop: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
        }
    }

    /**
     * Enviar notificación al cliente
     */
    private function sendNotificationToClient(array $appointment, string $type): void
    {
        try {
            Log::info('=== STARTING CLIENT NOTIFICATION ===');
            Log::info('Client notification data:', [
                'client_email' => $appointment['client_email'] ?? 'NULL',
                'appointment_id' => $appointment['appointment_id'] ?? 'NULL',
                'type' => $type
            ]);

            $appointmentModel = Appointments::find($appointment['appointment_id']);

            if ($appointmentModel) {
                $appointmentModel->load('workshop');

                Log::info('About to send email to client: ' . $appointment['client_email']);

                Mail::to($appointment['client_email'])->send(
                    new AppointmentNotification($appointmentModel, $type)
                );

                Log::info('✅ Email sent successfully to client: ' . $appointment['client_email']);
            } else {
                Log::error('❌ Appointment model not found for client notification');
            }

            Log::info('=== CLIENT NOTIFICATION COMPLETED ===');
        } catch (\Exception $e) {
            Log::error('❌ ERROR in sendNotificationToClient: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
        }
    }
}
