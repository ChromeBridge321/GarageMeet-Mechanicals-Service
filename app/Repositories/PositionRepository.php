<?php

namespace App\Repositories;

use App\Contracts\Repositories\PositionRepositoryInterface;
use App\Models\Positions;

class PositionRepository implements PositionRepositoryInterface
{
    public function create(array $data): array
    {
        $position = Positions::create($data);

        return [
            'positions_id' => $position->positions_id,
            'name' => $position->name,
            'mechanical_workshops_id' => $position->mechanical_workshops_id,
        ];
    }

    public function update(int $id, array $data): array
    {
        $position = Positions::findOrFail($id);
        $position->update($data);

        return [
            'positions_id' => $position->positions_id,
            'name' => $position->name,
            'mechanical_workshops_id' => $position->mechanical_workshops_id,
        ];
    }

    public function findById(int $id): ?array
    {
        $position = Positions::find($id);

        if (!$position) {
            return null;
        }

        return [
            'positions_id' => $position->positions_id,
            'name' => $position->name,
            'mechanical_workshops_id' => $position->mechanical_workshops_id,
        ];
    }

    public function delete(int $id): bool
    {
        $position = Positions::findOrFail($id);
        return $position->delete();
    }

    public function getAllByWorkshop(int $workshopId): array
    {
        $positions = Positions::where('mechanical_workshops_id', $workshopId)
            ->get()
            ->toArray();

            $positions = [
                'positions_id' => $positions[0]['positions_id'],
                'name' => $positions[0]['name']
            ];

        return $positions;
    }
}
