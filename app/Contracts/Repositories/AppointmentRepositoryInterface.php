<?php

namespace App\Contracts\Repositories;

interface AppointmentRepositoryInterface
{
    public function create(array $data): array;
    public function findById(int $id): ?array;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function getAllByWorkshop(int $workshopId, array $filters = []): array;
    public function findByToken(string $token): ?array;
}
