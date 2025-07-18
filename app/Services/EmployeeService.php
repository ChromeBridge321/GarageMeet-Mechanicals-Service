<?php

namespace App\Services;

use App\Contracts\Repositories\EmployeeRepositoryInterface;
use App\Contracts\Repositories\PeopleRepositoryInterface;
use App\Contracts\Services\EmployeeServiceInterface;
use App\Http\Requests\StorePeoplesRequest;
use App\Http\Requests\UpdatePeoplesRequest;
use Illuminate\Support\Facades\DB;

class EmployeeService implements EmployeeServiceInterface
{
    private PeopleRepositoryInterface $peopleRepository;
    private EmployeeRepositoryInterface $employeeRepository;

    public function __construct(
        PeopleRepositoryInterface $peopleRepository,
        EmployeeRepositoryInterface $employeeRepository
    ) {
        $this->peopleRepository = $peopleRepository;
        $this->employeeRepository = $employeeRepository;
    }

    public function createEmployee(StorePeoplesRequest $request): array
    {
        return DB::transaction(function () use ($request) {
            $validatedData = $request->validated();

            // Create person
            $person = $this->peopleRepository->create($validatedData);

            // Create employee
            $employeeData = [
                'mechanical_workshops_id' => $request['mechanicals_id'],
                'peoples_id' => $person['peoples_id'],
            ];
            $employee = $this->employeeRepository->create($employeeData);

            // Create employee position relationship
            $employeePosition = $this->employeeRepository->attachPosition(
                $employee['employees_id'],
                $request['positions_id']
            );

            return [
                'person' => $person,
                'employee' => $employee,
                'employee_position' => $employeePosition
            ];
        });
    }

    public function updateEmployee(UpdatePeoplesRequest $request): array
    {
        return DB::transaction(function () use ($request) {
            $validatedData = $request->validated();

            // Update person
            $person = $this->peopleRepository->update($validatedData['peoples_id'], $validatedData);

            // Update employee position
            $positionUpdated = $this->employeeRepository->updatePosition(
                $request['employees_id'],
                $request['positions_id'] ?? null,
                $request['new_positions_id']
            );

            return [
                'person' => $person,
                'employee_id' => $request['employees_id'],
                'position_updated' => $positionUpdated
            ];
        });
    }

    public function deleteEmployee(int $peopleId): bool
    {
        return DB::transaction(function () use ($peopleId) {
           // $this->employeeRepository->delete($peopleId);
            return $this->peopleRepository->delete($peopleId);
        });
    }

    public function getAllEmployees(int $workshopId): array
    {
        return $this->employeeRepository->getAllByWorkshop($workshopId);
    }
}
