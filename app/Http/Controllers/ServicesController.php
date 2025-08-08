<?php

namespace App\Http\Controllers;

use App\Contracts\Services\ServicesServiceInterface;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;


class ServicesController extends Controller
{
    private ServicesServiceInterface $servicesService;

    public function __construct(ServicesServiceInterface $servicesService)
    {
        $this->servicesService = $servicesService;
    }

    public function create(StoreServiceRequest $request)
    {
        try {
            $data = $request->validated();
            $service = $this->servicesService->createService($data);
            return ApiResponse::created('Service created successfully', $service);
        } catch (\Exception $e) {
            return ApiResponse::error('Error creating service', $e->getMessage());
        }
    }

    public function update(UpdateServiceRequest $request)
    {
        try {
            $data = $request->validated();
            $service = $this->servicesService->updateService($data['services_id'], $data);
            return ApiResponse::success('Service updated successfully', $service);
        } catch (\Exception $e) {
            return ApiResponse::error('Error updating service', $e->getMessage());
        }
    }

    public function getAll(Request $request)
    {
        try {
            $workshopId = $request->mechanical_workshops_id;

            if (!$workshopId) {
                return ApiResponse::error('Workshop ID is required');
            }

            $services = $this->servicesService->getAllServices($workshopId);
            return response()->json($services);
        } catch (\Exception $e) {
            return ApiResponse::error('Error retrieving services', $e->getMessage());
        }
    }

    public function getById(Request $request)
    {
        try {
            $serviceId = $request->services_id;
            $mechanicalId = $request->mechanical_workshops_id;

            if (!$serviceId || !$mechanicalId) {
                return ApiResponse::error('Service ID and Mechanical ID are required');
            }

            $service = $this->servicesService->findService($serviceId, $mechanicalId);

            if (!$service) {
                return ApiResponse::notFound('Service not found');
            }

            return response()->json($service);
        } catch (\Exception $e) {
            return ApiResponse::error('Error retrieving service', $e->getMessage());
        }
    }

    public function delete(Request $request)
    {
        try {

            $this->servicesService->deleteService($request->services_id);
            return ApiResponse::success('Service deleted successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return ApiResponse::error('Validation failed', $e->getMessage(), 422);
        } catch (\Exception $e) {
            return ApiResponse::error('Error deleting service', $e->getMessage());
        }
    }
}
