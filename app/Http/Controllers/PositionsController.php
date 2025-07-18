<?php

namespace App\Http\Controllers;

use App\Contracts\Services\PositionServiceInterface;
use App\Http\Requests\StorePositionRequest;
use App\Http\Requests\UpdatePositionRequest;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;

class PositionsController extends Controller
{
    private PositionServiceInterface $positionService;

    public function __construct(PositionServiceInterface $positionService)
    {
        $this->positionService = $positionService;
    }

    public function create(StorePositionRequest $request)
    {
        try {
            $data = $request->validated();
            $position = $this->positionService->createPosition($data);
            return ApiResponse::created('Position created successfully', $position);
        } catch (\Exception $e) {
            return ApiResponse::error('Error creating position', $e->getMessage());
        }
    }

    public function update(UpdatePositionRequest $request)
    {
        try {
            $data = $request->validated();
            $position = $this->positionService->updatePosition(
                $data['positions_id'],
                ['name' => $data['name']]
            );
            return ApiResponse::success('Position updated successfully', $position);
        } catch (\Exception $e) {
            return ApiResponse::error('Error updating position', $e->getMessage());
        }
    }

    public function delete(Request $request)
    {
        try {
            $data = $request->validate([
                'positions_id' => 'required|exists:positions,positions_id',
            ]);

            $this->positionService->deletePosition($data['positions_id']);
            return ApiResponse::success('Position deleted successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return ApiResponse::error('Validation failed', $e->getMessage(), 422);
        } catch (\Exception $e) {
            return ApiResponse::error('Error deleting position', $e->getMessage());
        }
    }

    public function getAll(Request $request)
    {
        try {
            $data = $request->validate([
                'mechanical_workshops_id' => 'required|exists:mechanical_workshops,id',
            ]);

            $positions = $this->positionService->getAllPositions($data['mechanical_workshops_id']);
            return response()->json($positions);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return ApiResponse::error('Validation failed', $e->getMessage(), 422);
        } catch (\Exception $e) {
            return ApiResponse::error('Error retrieving positions', $e->getMessage());
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $position = $this->positionService->findPosition($id);

            if (!$position) {
                return ApiResponse::notFound('Position not found');
            }

            return response()->json($position);
        } catch (\Exception $e) {
            return ApiResponse::error('Error retrieving position', $e->getMessage());
        }
    }
}
