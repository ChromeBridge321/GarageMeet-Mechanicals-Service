<?php

namespace App\Services;

use App\Contracts\Repositories\PiecesRepositoryInterface;
use App\Contracts\Services\PiecesServiceInterface;

class PiecesService implements PiecesServiceInterface
{
    private PiecesRepositoryInterface $piecesRepository;

    public function __construct(PiecesRepositoryInterface $piecesRepository)
    {
        $this->piecesRepository = $piecesRepository;
    }

    public function createPiece(array $data): array
    {
        return $this->piecesRepository->create($data);
    }

    public function updatePiece(int $id, array $data): array
    {
        return $this->piecesRepository->update($id, $data);
    }

    public function deletePiece(int $id): bool
    {
        return $this->piecesRepository->delete($id);
    }

    public function getAllPieces(int $workshopId): array
    {
        return $this->piecesRepository->getAllByWorkshop($workshopId);
    }

    public function findPiece(int $id, int $mechanical_id): ?array
    {
        return $this->piecesRepository->findById($id, $mechanical_id);
    }
}
