<?php

namespace App\Services;

use App\Contracts\Services\VehiclesServiceInterface;
use App\Repositories\VehiclesRepository;

class VehiclesService implements VehiclesServiceInterface
{
    private VehiclesRepository $VehiclesGetRepository;

    public function __construct(VehiclesRepository $VehiclesGetRepository)
    {
        $this->VehiclesGetRepository = $VehiclesGetRepository;
    }

    public function AllModels(): array
    {
        return $this->VehiclesGetRepository->getAllModels();
    }

    public function AllMakes(): array
    {
        return $this->VehiclesGetRepository->getAllMakes();
    }

    public function ModelByName(string $name): array
    {
        return $this->VehiclesGetRepository->getModelByName($name);
    }

    public function MakeByName(string $name): array
    {
        return $this->VehiclesGetRepository->getMakeByName($name);
    }

    public function ModelsByMakeId(int $makeId): array
    {
        return $this->VehiclesGetRepository->getModelsByMakeId($makeId);
    }

    public function ModelMakeByMakesModelId(int $makesModelId): array
    {
        return $this->VehiclesGetRepository->getModelMakeByMakesModelId($makesModelId);
    }
}
