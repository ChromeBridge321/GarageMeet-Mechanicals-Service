<?php

namespace App\Http\Controllers;

use App\Contracts\Services\SalesServiceInterface;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    private SalesServiceInterface $salesService;

    public function __construct(SalesServiceInterface $salesService)
    {
        $this->salesService = $salesService;
    }

    public function create(StoreSaleRequest $request)
    {
        try {
            $data = $request->validated();
            $result = $this->salesService->createSale($data);
            return ApiResponse::created('Sale created successfully', $result);
        } catch (\Exception $e) {
            return ApiResponse::error('Error creating sale', $e->getMessage());
        }
    }

    public function update(UpdateSaleRequest $request)
    {
        try {
            $data = $request->validated();
            $piece = $this->salesService->updateSale(
                $data['services_sales_id'],
                $data
            );
            return ApiResponse::success('Sale updated successfully', $piece);
        } catch (\Exception $e) {
            return ApiResponse::error('Error updating sale', $e->getMessage());
        }
    }

    public function delete(Request $request)
    {
        try {
            $data = $request->validate([
                'services_sales_id' => 'required|exists:services_sales,services_sales_id',
            ]);

            $this->salesService->deleteSale($data['services_sales_id']);
            return ApiResponse::success('Sale deleted successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return ApiResponse::error('Validation failed', $e->getMessage(), 422);
        } catch (\Exception $e) {
            return ApiResponse::error('Error deleting sale', $e->getMessage());
        }
    }

    public function getAll(Request $request)
    {
        $workshopId = $request->mechanical_workshops_id;
        return $this->salesService->getAllSales($workshopId);
    }

    public function getById(Request $request)
    {
        $id = $request->services_sales_id;
        $mechanical_id = $request->mechanical_workshops_id;
        return $this->salesService->findSale($id, $mechanical_id);
    }
}
