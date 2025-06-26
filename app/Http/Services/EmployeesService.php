<?php

namespace App\Http\Services;

use App\Models\Employees;
use App\Models\Peoples;
use Illuminate\Http\Response;

class EmployeesService
{
    public function create(array $data)
    {
        $employee = Employees::create($data);
        $employee = [
            'employees_id' => $employee->employees_id,
            'mechanical_workshops_id' => $employee->mechanical_workshops_id,
            'peoples_id' => $employee->peoples_id,
        ];
        return $employee;
    }

    public function update(array $data)
    {
        $employee = Employees::findOrFail($data['employees_id']);
        $employee->update($data);
        $employee = [
            'employees_id' => $employee->employees_id,
            'mechanical_workshops_id' => $employee->mechanical_workshops_id,
            'peoples_id' => $employee->peoples_id,
        ];
        return $employee;
    }

    public function parseCreateData($data, $person)
    {

        $employee = [
            'positions_id' => $data['positions_id'],
            'mechanical_workshops_id' => $data['mechanicals_id'],
            'peoples_id' => $person['peoples_id'],
        ];

        return $employee;
    }

    public function parseUpdateData($data)
    {
        $employee = [
            'employees_id' => $data['employees_id'],
            'positions_id' => $data['positions_id'],
        ];

        return $employee;
    }

    public function getAll($workshopId)
    {
        $employees = Employees::with(['person'])
            ->where('mechanical_workshops_id', $workshopId)
            ->get();
        return $employees;
    }

    public function delete($peoples_id, $employees_id)
    {
        $person = Peoples::findOrFail($peoples_id);
        $employee = Employees::findOrFail($employees_id);
        $person->delete();
        $employee->delete();
        return response()->json(['message' => 'Employee deleted successfully'], Response::HTTP_OK);
    }
}
