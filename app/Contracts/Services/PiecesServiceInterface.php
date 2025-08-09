<?php

namespace App\Contracts\Services;

interface PiecesServiceInterface
{
    public function createPiece(array $data): array;
    public function updatePiece(int $id, array $data): array;
    public function deletePiece(int $id): bool;
    public function getAllPieces(int $workshopId): array;
    public function findPiece(int $id, int $mechanical_id): ?array;
}
