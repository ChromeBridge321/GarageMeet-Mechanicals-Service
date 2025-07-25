<?php

namespace App\Contracts\Repositories;

interface EmployeeRepositoryInterface
{
    public function create(array $data): array;
    public function update(int $id, array $data): array;
    public function findById(int $employeeId): ?array;
    //public function delete(int $id): bool;
    public function getAllByWorkshop(int $workshopId): array;
    public function attachPosition(int $employeeId, int $positionId): array;
    public function updatePosition(int $employeeId, int $oldPositionId, int $newPositionId): bool;
}
