<?php

namespace App\Contracts\Services;

use Illuminate\Http\Request;

interface PositionServiceInterface
{
    public function createPosition(array $data): array;
    public function updatePosition(int $id, array $data): array;
    public function deletePosition(int $id): bool;
    public function getAllPositions(int $workshopId): array;
    public function findPosition(int $id): ?array;
}
