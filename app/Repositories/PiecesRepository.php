<?php

namespace App\Repositories;

use App\Contracts\Repositories\PiecesRepositoryInterface;
use App\Models\Pieces;

class PiecesRepository implements PiecesRepositoryInterface
{
    public function create(array $data): array
    {
        $piece = Pieces::create($data);

        return [
            'pieces_id' => $piece->pieces_id,
            'name' => $piece->name,
            'mechanical_workshops_id' => $piece->mechanical_workshops_id,
            'price' => $piece->price,
        ];
    }

    public function update(int $id, array $data): array
    {
        $piece = Pieces::findOrFail($id);
        $piece->update($data);

        return [
            'pieces_id' => $piece->pieces_id,
            'name' => $piece->name,
            'mechanical_workshops_id' => $piece->mechanical_workshops_id,
            'price' => $piece->price,
        ];
    }

    public function findById(int $id, int $mechanical_id): ?array
    {
        $piece = Pieces::where('pieces_id', $id)
            ->where('mechanical_workshops_id', $mechanical_id)
            ->first();

        if (!$piece) {
            return null;
        }

        return [
            'pieces_id' => $piece->pieces_id,
            'name' => $piece->name,
            'mechanical_workshops_id' => $piece->mechanical_workshops_id,
            'price' => $piece->price,
        ];
    }

    public function delete(int $id): bool
    {
        $piece = Pieces::findOrFail($id);
        return $piece->delete();
    }

    public function getAllByWorkshop(int $workshopId): array
    {
        $pieces = Pieces::where('mechanical_workshops_id', $workshopId)->get();

        return $pieces->map(function ($piece) {
            return [
                'pieces_id' => $piece->pieces_id,
                'name' => $piece->name,
                'mechanical_workshops_id' => $piece->mechanical_workshops_id,
                'price' => $piece->price,
            ];
        })->toArray();
    }
}
