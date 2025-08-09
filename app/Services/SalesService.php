<?php

namespace App\Services;
use App\Contracts\Repositories\SalesRepositoryInterface;
use App\Contracts\Services\SalesServiceInterface;

class SalesService implements SalesServiceInterface
{
    private SalesRepositoryInterface $salesRepository;

    public function __construct(SalesRepositoryInterface $salesRepository)
    {
        $this->salesRepository = $salesRepository;
    }

    public function createSale(array $data): array
    {
        return $this->salesRepository->create($data);
    }

    public function updateSale(int $id, array $data): array
    {
        return $this->salesRepository->update($id, $data);
    }

    public function deleteSale(int $id): bool
    {
        return $this->salesRepository->delete($id);
    }

    public function getAllSales(int $workshopId): array
    {
        return $this->salesRepository->getAllByWorkshop($workshopId);
    }

    public function findSale(int $id, int $mechanical_id): ?array
    {
        return $this->salesRepository->findById($id, $mechanical_id);
    }
}
