<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\PositionsService;
use Illuminate\Http\Response;

class PositionsController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    protected $positionsService;
    public function __construct(PositionsService $positionsService)
    {
        $this->positionsService = $positionsService;
    }
    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:60',
            'mechanical_workshops_id' => 'required|exists:mechanical_workshops,id',
        ]);

        $data = $this->positionsService->create($data);
        return response()->json([
            'message' => 'Position created successfully',
            'data' => $data
        ], Response::HTTP_CREATED);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'positions_id' => 'required|exists:positions,positions_id',
            'name' => 'required|string|max:60',
        ]);

        $data = $this->positionsService->update($data);
        return response()->json([
            'message' => 'Position updated successfully',
            'data' => $data
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $data = $request->validate([
            'positions_id' => 'required|exists:positions,positions_id',
        ]);

        $position = $this->positionsService->delete($data['positions_id']);
        return $position;
    }

    public function getAll(Request $request)
    {
        $data = $request->validate([
            'mechanical_workshops_id' => 'required|exists:mechanical_workshops,id',
        ]);
        $positions = $this->positionsService->getAll($data['mechanical_workshops_id']);
        return response()->json([
            'message' => 'Positions retrieved successfully',
            'data' => $positions
        ], Response::HTTP_OK);
    }
}
