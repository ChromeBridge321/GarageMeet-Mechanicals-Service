<?php
namespace App\Contracts\Services;
interface VehiclesServiceInterface
{
    public function AllModels(): array;
    public function AllMakes(): array;
    public function ModelByName(string $name): array;
    public function MakeByName(string $name): array;
    public function ModelsByMakeId(int $makeId): array;
    public function ModelMakeByMakesModelId(int $makesModelId): array;
}
