<?php

namespace App\Contracts\Repositories;

interface MechanicalWorkshopRepositoryInterface
{
    public function create(array $data): array;
    public function update(int $id, array $data): array;
    public function findById(int $id): ?array;
    public function delete(int $id): bool;
    public function getAllByUser(int $userId): array;
    public function getAll(): array;
    public function getAllByState(string $state): array;
    public function getAllByStateAndCity(string $state, string $city): array;
}
