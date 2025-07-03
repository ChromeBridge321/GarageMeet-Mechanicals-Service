<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePeoplesRequest;
use App\Http\Requests\UpdatePeoplesRequest;
use App\Http\Services\EmployeesService;
use App\Http\Services\PeoplesService;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    protected $employeesService;
    protected $peoplesService;

    public function __construct(EmployeesService $employeesService, PeoplesService $peoplesService)
    {
        $this->employeesService = $employeesService;
        $this->peoplesService = $peoplesService;
    }

    public function create(StorePeoplesRequest $request)
    {

        $person = $this->peoplesService->create($request->validated());
        $employee = $this->employeesService->parseCreateData($request, $person);
        $employee = $this->employeesService->create($employee);

        $employeesPositions = [
            'employees_id' => $employee['employees_id'],
            'positions_id' => $request['positions_id']
        ];

        $employeesPositions = $this->employeesService->createEmployeesPositions($employeesPositions);
        return response()->json([
            'message' => 'Employee created successfully',
            'Person' => $person,
            'Employee' => $employee,
            'EmployeesPositions' => $employeesPositions
        ], Response::HTTP_CREATED);
    }

    public function update(UpdatePeoplesRequest $request)
    {
        $person = $this->peoplesService->update($request->validated());
        $employee = $this->employeesService->parseUpdateData($request);
        // $employee = $this->employeesService->update($employee);
        $employeesPositions = [
            'employees_id' => $employee['employees_id'],
            'positions_id' => $request['positions_id'],
            'new_positions_id' => $request['new_positions_id']
        ];
        $employeesPositions = $this->employeesService->updateEmployeesPositions($employeesPositions);
        return response()->json([
            'message' => 'Employee updated successfully',
            'Person' => $person,
            'Employee' => $employee,
            'EmployeesPositions' => $employeesPositions
        ], Response::HTTP_OK);
    }

    public function delete(Request $request)
    {
        $this->employeesService->delete($request['peoples_id'], $request['employees_id']);
        return response()->json(['message' => 'Employee deleted successfully'], Response::HTTP_OK);
    }

    public function getAll(Request $request)
    {
        $employees = $this->employeesService->getAll($request['mechanical_workshops_id']);
        return response()->json($employees, Response::HTTP_OK);
    }
}
