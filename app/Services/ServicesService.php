<?php

namespace App\Services;
use App\Contracts\Repositories\ServicesRepositoryInterface;
use App\Contracts\Services\ServicesServiceInterface;

class ServicesService implements ServicesServiceInterface
{
    private ServicesRepositoryInterface $servicesRepository;

    public function __construct(ServicesRepositoryInterface $servicesRepository)
    {
        $this->servicesRepository = $servicesRepository;
    }

    public function createService(array $data): array
    {
        return $this->servicesRepository->create($data);
    }

    public function updateService(int $id, array $data): array
    {
        return $this->servicesRepository->update($id, $data);
    }

    public function deleteService(int $id): bool
    {
        return $this->servicesRepository->delete($id);
    }

    public function getAllServices(int $workshopId): array
    {
        return $this->servicesRepository->getAllByWorkshop($workshopId);
    }

    public function findService(int $id, int $mechanical_id): ?array
    {
        return $this->servicesRepository->findById($id, $mechanical_id);
    }
}
