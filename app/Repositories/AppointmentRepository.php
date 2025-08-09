<?php

namespace App\Repositories;

use App\Contracts\Repositories\AppointmentRepositoryInterface;
use App\Models\Appointments;

class AppointmentRepository implements AppointmentRepositoryInterface
{
    public function create(array $data): array
    {
        $appointment = Appointments::create($data);
        return $appointment->load('workshop')->toArray();
    }

    public function findById(int $id): ?array
    {
        $appointment = Appointments::with('workshop')->find($id);
        return $appointment ? $appointment->toArray() : null;
    }

    public function update(int $id, array $data): bool
    {
        $appointment = Appointments::findOrFail($id);
        return $appointment->update($data);
    }

    public function delete(int $id): bool
    {
        $appointment = Appointments::findOrFail($id);
        return $appointment->delete();
    }

    public function getAllByWorkshop(int $workshopId, array $filters = []): array
    {
        $query = Appointments::byWorkshop($workshopId)->with('workshop');

        // Filtros opcionales
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['date_from'])) {
            $query->whereDate('appointment_date', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to'])) {
            $query->whereDate('appointment_date', '<=', $filters['date_to']);
        }

        if (isset($filters['created_by'])) {
            $query->where('created_by', $filters['created_by']);
        }

        return $query->orderBy('created_at', 'desc')->get()->toArray();
    }

    public function findByToken(string $token): ?array
    {
        $appointment = Appointments::with('workshop')
                                  ->where('cancellation_token', $token)
                                  ->first();

        return $appointment ? $appointment->toArray() : null;
    }

    public function getPendingAppointments(int $workshopId): array
    {
        return Appointments::byWorkshop($workshopId)
                          ->pending()
                          ->with('workshop')
                          ->orderBy('created_at', 'desc')
                          ->get()
                          ->toArray();
    }

    public function getUpcomingAppointments(int $workshopId): array
    {
        return Appointments::byWorkshop($workshopId)
                          ->confirmed()
                          ->where('appointment_date', '>', now())
                          ->with('workshop')
                          ->orderBy('appointment_date', 'asc')
                          ->get()
                          ->toArray();
    }
}
