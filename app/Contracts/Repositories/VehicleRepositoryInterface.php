<?php

namespace App\Contracts\Repositories;

interface VehicleRepositoryInterface
{
    public function create(array $data): array;
    public function update(int $id, array $data): array;
    public function findById(int $id): ?array;
    public function delete(int $id): bool;
    public function getByClientId(int $clientId): array;
}
