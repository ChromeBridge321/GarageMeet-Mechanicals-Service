<?php

namespace App\Contracts\Services;

interface AppointmentServiceInterface
{
    public function createAppointmentRequest(array $data): array;
    public function confirmAppointment(array $data): array;
    public function cancelAppointment(int $id): array;
    public function cancelAppointmentByToken(string $token): array;
    public function getAllAppointments(int $workshopId, array $filters = []): array;
    public function getAppointmentById(int $id): ?array;
    public function sendReminder(int $id): void;
}
