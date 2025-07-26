<?php

namespace App\Services;

use App\Contracts\Repositories\PositionRepositoryInterface;
use App\Contracts\Services\PositionServiceInterface;

class PositionService implements PositionServiceInterface
{
    private PositionRepositoryInterface $positionRepository;

    public function __construct(PositionRepositoryInterface $positionRepository)
    {
        $this->positionRepository = $positionRepository;
    }

    public function createPosition(array $data): array
    {
        return $this->positionRepository->create($data);
    }

    public function updatePosition(int $id, array $data): array
    {
        return $this->positionRepository->update($id, $data);
    }

    public function deletePosition(int $id): bool
    {
        return $this->positionRepository->delete($id);
    }

    public function getAllPositions(int $workshopId): array
    {
        return $this->positionRepository->getAllByWorkshop($workshopId);
    }

    public function findPosition(int $id, int $mechanical_id): ?array
    {
        return $this->positionRepository->findById($id, $mechanical_id);
    }
}
