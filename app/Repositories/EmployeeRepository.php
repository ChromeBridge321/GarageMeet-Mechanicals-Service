<?php

namespace App\Repositories;

use App\Contracts\Repositories\EmployeeRepositoryInterface;
use App\Models\Employees;
use App\Models\Employees_positions;
use Illuminate\Support\Facades\DB;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    public function create(array $data): array
    {
        $employee = Employees::create($data);

        return [
            'employees_id' => $employee->employees_id,
            'mechanical_workshops_id' => $employee->mechanical_workshops_id,
            'peoples_id' => $employee->peoples_id,
        ];
    }

    public function update(int $id, array $data): array
    {
        $employee = Employees::findOrFail($id);
        $employee->update($data);

        return [
            'employees_id' => $employee->employees_id,
            'mechanical_workshops_id' => $employee->mechanical_workshops_id,
            'peoples_id' => $employee->peoples_id,
        ];
    }

    public function findById(int $employeeId): ?array
    {
        $employee = Employees::with(['person', 'positions'])
            ->where('employees_id', $employeeId)
            ->first();

        if (!$employee) {
            return null;
        }
        return [
            'employees_id' => $employee->employees_id,
            'mechanical_workshops_id' => $employee->mechanical_workshops_id,
            'peoples_id' => $employee->peoples_id,
            'person' => $employee->person,
            'positions' => $employee->positions
        ];
    }

    public function delete(int $id): bool
    {
        $employee = Employees::findOrFail($id);
        return $employee->delete();
    }

    public function getAllByWorkshop(int $workshopId): array
    {
        $employees =  Employees::with(['person', 'positions'])
            ->where('mechanical_workshops_id', $workshopId)
            ->get()
            ->toArray();
        return $employees;
    }

    public function attachPosition(int $employeeId, int $positionId): array
    {
        $data = [
            'employees_id' => $employeeId,
            'positions_id' => $positionId
        ];

        $employeePosition = Employees_positions::create($data);
        return $employeePosition->toArray();
    }

    public function updatePosition(int $employeeId, int $oldPositionId, int $newPositionId): bool
    {
        if ($oldPositionId === null) {
            $this->attachPosition($employeeId, $newPositionId);
            return true;
        }

        $updated = DB::table('employes_positions')
            ->where('employees_id', $employeeId)
            ->where('positions_id', $oldPositionId)
            ->update([
                'positions_id' => $newPositionId,
                'updated_at' => now()
            ]);

        return $updated > 0;
    }
}
