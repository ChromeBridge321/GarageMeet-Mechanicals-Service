<?php

namespace App\Services;

use App\Contracts\Repositories\MechanicalWorkshopRepositoryInterface;
use App\Contracts\Services\MechanicalWorkshopServiceInterface;
use App\Http\Requests\StoreMechanicalsRequest;
use App\Http\Requests\UpdateMechanicalsRequest;

class MechanicalWorkshopService implements MechanicalWorkshopServiceInterface
{
    private MechanicalWorkshopRepositoryInterface $workshopRepository;

    public function __construct(MechanicalWorkshopRepositoryInterface $workshopRepository)
    {
        $this->workshopRepository = $workshopRepository;
    }

    public function createWorkshop(StoreMechanicalsRequest $request): array
    {
        $validatedData = $request->validated();
        return $this->workshopRepository->create($validatedData);
    }

    public function updateWorkshop(UpdateMechanicalsRequest $request): array
    {
        $validatedData = $request->validated();
        $workshopId = $validatedData['id'];

        return $this->workshopRepository->update($workshopId, $validatedData);
    }

    public function deleteWorkshop(int $id): bool
    {
        return $this->workshopRepository->delete($id);
    }

    public function findWorkshop(int $id): ?array
    {
        return $this->workshopRepository->findById($id);
    }

    public function getAllWorkshopsByUser(int $userId): array
    {
        return $this->workshopRepository->getAllByUser($userId);
    }
}
