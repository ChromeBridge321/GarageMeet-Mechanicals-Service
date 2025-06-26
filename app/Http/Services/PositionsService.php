<?php

namespace App\Http\Services;

use App\Models\Positions;
use Illuminate\Http\Response;

class PositionsService
{
    public function create(array $data)
    {
        $position = Positions::create($data);
        $position = [
            'positions_id' => $position->positions_id,
            'name' => $position->name,
            'mechanical_workshops_id' => $position->mechanical_workshops_id,
        ];
        return $position;
    }

    public function update(array $data)
    {
        $position = Positions::findOrFail($data['positions_id']);
        $position->update($data);
        return $position;
    }

    public function delete(int $id)
    {
        $position = Positions::findOrFail($id);
        $position->delete();
        return response()->json(['message' => 'Position deleted successfully'], Response::HTTP_OK);
    }

    public function getAll($mechanical_workshops_id)
    {
        return Positions::where('mechanical_workshops_id', $mechanical_workshops_id)->get();
    }
}
