<?php

namespace App\Http\Controllers;

use App\Contracts\Services\EmployeeServiceInterface;
use App\Http\Requests\StorePeoplesRequest;
use App\Http\Requests\UpdatePeoplesRequest;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    private EmployeeServiceInterface $employeeService;

    public function __construct(EmployeeServiceInterface $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function create(StorePeoplesRequest $request)
    {
        try {
            $result = $this->employeeService->createEmployee($request);
            return ApiResponse::created('Employee created successfully', $result);
        } catch (\Exception $e) {
            return ApiResponse::error('Error creating employee', $e->getMessage());
        }
    }

    public function update(UpdatePeoplesRequest $request)
    {
        try {
            $result = $this->employeeService->updateEmployee($request);
            return ApiResponse::success('Employee updated successfully', $result);
        } catch (\Exception $e) {
            return ApiResponse::error('Error updating employee', $e->getMessage());
        }
    }

    public function delete(Request $request)
    {
        try {
            $this->employeeService->deleteEmployee(
                $request['peoples_id']
            );
            return ApiResponse::success('Employee deleted successfully');
        } catch (\Exception $e) {
            return ApiResponse::error('Error deleting employee', $e->getMessage());
        }
    }

    public function getAll(Request $request)
    {
        try {
            $employees = $this->employeeService->getAllEmployees($request['mechanical_workshops_id']);
            return response()->json($employees);
        } catch (\Exception $e) {
            return ApiResponse::error('Error retrieving employees', $e->getMessage());
        }
    }
}
