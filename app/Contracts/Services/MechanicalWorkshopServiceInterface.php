<?php

namespace App\Contracts\Services;

use App\Http\Requests\StoreMechanicalsRequest;
use App\Http\Requests\UpdateMechanicalsRequest;

interface MechanicalWorkshopServiceInterface
{
    public function createWorkshop(StoreMechanicalsRequest $request): array;
    public function updateWorkshop(UpdateMechanicalsRequest $request): array;
    public function deleteWorkshop(int $id): bool;
    public function findWorkshop(int $id): ?array;
    public function getAllWorkshopsByUser(int $userId): array;
}
