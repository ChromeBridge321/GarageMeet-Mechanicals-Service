<?php

namespace App\Http\Controllers;

use App\Contracts\Services\PaymentTypesServiceInterface;
use App\Http\Requests\StorePaymentTypesRequest;
use App\Http\Requests\UpdatePaymentTypesRequest;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;

class PaymentTypesContoller extends Controller
{
    private PaymentTypesServiceInterface $paymentTypesService;

    public function __construct(PaymentTypesServiceInterface $paymentTypesService)
    {
        $this->paymentTypesService = $paymentTypesService;
    }

    public function create(StorePaymentTypesRequest $request)
    {
        try {
            $data = $request->validated();
            $paymentType = $this->paymentTypesService->createPaymentType($data);
           return ApiResponse::created('Payment type created successfully', $paymentType);
        } catch (\Exception $e) {
            return ApiResponse::error('Error creating payment type', $e->getMessage());
        }
    }

    public function update(UpdatePaymentTypesRequest $request)
    {
        try {
            $data = $request->validated();
            $paymentType = $this->paymentTypesService->updatePaymentType($data['payment_types_id'], $data);
           return ApiResponse::success('Payment type updated successfully', $paymentType);
        } catch (\Exception $e) {
            return ApiResponse::error('Error updating payment type', $e->getMessage());
        }
    }

    public function getAll(Request $request)
    {
        try {
            $workshopId = $request->mechanical_workshops_id;

            if (!$workshopId) {
                return ApiResponse::error('Workshop ID is required');
            }

            $paymentTypes = $this->paymentTypesService->getAllPaymentTypes($workshopId);
            return response()->json($paymentTypes);
        } catch (\Exception $e) {
            return ApiResponse::error('Error retrieving payment types', $e->getMessage());
        }
    }

    public function getById(Request $request)
    {
        try {
            $paymentTypeId = $request->payment_types_id;
            $mechanicalId = $request->mechanical_workshops_id;

            if (!$paymentTypeId || !$mechanicalId) {
                return ApiResponse::error('Payment Type ID and Mechanical ID are required');
            }

            $paymentType = $this->paymentTypesService->findPaymentType($paymentTypeId, $mechanicalId);

            if (!$paymentType) {
                return ApiResponse::notFound('Payment type not found');
            }

            return response()->json($paymentType);
        } catch (\Exception $e) {
            return ApiResponse::error('Error retrieving payment type', $e->getMessage());
        }
    }

    public function delete(Request $request)
    {
        try {

            $this->paymentTypesService->deletePaymentType($request->payment_types_id);
            return ApiResponse::success('Payment type deleted successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return ApiResponse::error('Validation failed', $e->getMessage(), 422);
        } catch (\Exception $e) {
            return ApiResponse::error('Error deleting payment type', $e->getMessage());
        }
    }
}
