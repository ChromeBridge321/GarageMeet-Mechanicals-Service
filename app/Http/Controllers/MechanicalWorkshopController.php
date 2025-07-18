<?php

namespace App\Http\Controllers;

use App\Contracts\Services\MechanicalWorkshopServiceInterface;
use App\Http\Requests\StoreMechanicalsRequest;
use App\Http\Requests\UpdateMechanicalsRequest;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;

class MechanicalWorkshopController extends Controller
{
    private MechanicalWorkshopServiceInterface $mechanicalWorkshopService;

    public function __construct(MechanicalWorkshopServiceInterface $mechanicalWorkshopService)
    {
        $this->mechanicalWorkshopService = $mechanicalWorkshopService;
    }

    public function create(StoreMechanicalsRequest $request)
    {
        try {
            $workshop = $this->mechanicalWorkshopService->createWorkshop($request);
            return ApiResponse::created('Mechanical workshop created successfully', $workshop);
        } catch (\Exception $e) {
            return ApiResponse::error('Error creating mechanical workshop', $e->getMessage());
        }
    }

    public function update(UpdateMechanicalsRequest $request)
    {
        try {
            $workshop = $this->mechanicalWorkshopService->updateWorkshop($request);
            return ApiResponse::success('Mechanical workshop updated successfully', $workshop);
        } catch (\Exception $e) {
            return ApiResponse::error('Error updating mechanical workshop', $e->getMessage());
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $this->mechanicalWorkshopService->deleteWorkshop($id);
            return ApiResponse::success('Mechanical workshop deleted successfully');
        } catch (\Exception $e) {
            return ApiResponse::error('Error deleting mechanical workshop', $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $workshop = $this->mechanicalWorkshopService->findWorkshop($id);

            if (!$workshop) {
                return ApiResponse::notFound('Mechanical workshop not found');
            }

            return response()->json($workshop);
        } catch (\Exception $e) {
            return ApiResponse::error('Error retrieving mechanical workshop', $e->getMessage());
        }
    }

    public function getAllByUser(Request $request, $userId)
    {
        try {
            $workshops = $this->mechanicalWorkshopService->getAllWorkshopsByUser($userId);
            return response()->json($workshops);
        } catch (\Exception $e) {
            return ApiResponse::error('Error retrieving mechanical workshops', $e->getMessage());
        }
    }
}
