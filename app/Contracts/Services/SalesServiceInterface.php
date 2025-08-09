<?php

namespace App\Contracts\Services;

interface SalesServiceInterface
{
    public function createSale(array $data): array;
    public function updateSale(int $id, array $data): array;
    public function deleteSale(int $id): bool;
    public function getAllSales(int $workshopId): array;
    public function findSale(int $id, int $mechanical_id): ?array;
}
