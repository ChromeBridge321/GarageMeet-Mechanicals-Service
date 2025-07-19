<?php

namespace App\Contracts\Repositories;

interface VehiclesRepositoryInterface
{
    public function getAllModels(): array;
    public function getAllMakes(): array;
    public function getModelByName(string $name): array;
    public function getMakeByName(string $name): array;
    public function getModelsByMakeId(int $makeId): array;
    public function getModelMakeByMakesModelId(int $makesModelId): array;
}
