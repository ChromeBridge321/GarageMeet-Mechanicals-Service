<?php

namespace App\Contracts\Repositories;

interface SalesRepositoryInterface
{
    public function create(array $data): array;
    public function update(int $id, array $data): array;
    public function findById(int $id, int $mechanical_id): ?array;
    public function delete(int $id): bool;
    public function getAllByWorkshop(int $workshopId): array;
}
