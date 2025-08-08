<?php

namespace App\Contracts\Services;

use Illuminate\Http\Request;

interface ServicesServiceInterface
{
    public function createService(array $data): array;
    public function updateService(int $id, array $data): array;
    public function deleteService(int $id): bool;
    public function getAllServices(int $workshopId): array;
    public function findService(int $id, int $mechanical_id): ?array;
}
