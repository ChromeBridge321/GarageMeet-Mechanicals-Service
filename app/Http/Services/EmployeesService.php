<?php

namespace App\Http\Services;

use App\Models\Employees;
use App\Models\Employees_positions;
use App\Models\Peoples;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

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




    public function parseCreateData($data, $person)
    {

        $employee = [
            'positions_id' => $data['positions_id'],
            'mechanical_workshops_id' => $data['mechanicals_id'],
            'peoples_id' => $person['peoples_id'],
        ];

        return $employee;
    }

    public function parseUpdateData(object $data)
    {
        if ($data['positions_id'] == null) {
            $employee = [
                'employees_id' => $data['employees_id'],
                'positions_id' => $data['new_positions_id'],
            ];
        }
        $employee = [
            'employees_id' => $data['employees_id'],
            'positions_id' => $data['positions_id'],
        ];

        return $employee;
    }

    public function getAll($workshopId)
    {
        $employees = Employees::with(['person', 'positions'])
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
    public function createEmployeesPositions(array $data)
    {
        // Aquí puedes implementar la lógica para crear las relaciones en la tabla intermedia
        // Por ejemplo:
        $employeePosition = Employees_positions::create($data);
        return $employeePosition;
    }

    public function updateEmployeesPositions(array $data)
    {

        // Verificar si los datos necesarios están presentes
        if ($data['positions_id'] == null) {
            $data = [
                'employees_id' => $data['employees_id'],
                'positions_id' => $data['new_positions_id']
            ];
            $updated = Employees_positions::create($data);
            return $updated;
        }
        // Usar query builder para evitar problemas con clave primaria
        $updated = DB::table('employes_positions')
            ->where('employees_id', $data['employees_id'])
            ->where('positions_id', $data['positions_id'])
            ->update([
                'positions_id' => $data['new_positions_id'],
                'updated_at' => now()
            ]);
        return $updated;
    }
}
