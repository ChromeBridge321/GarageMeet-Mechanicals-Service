<?php

namespace App\Contracts\Services;

use App\Http\Requests\StorePeoplesRequest;
use App\Http\Requests\UpdatePeoplesRequest;

interface EmployeeServiceInterface
{
    public function createEmployee(StorePeoplesRequest $request): array;
    public function updateEmployee(UpdatePeoplesRequest $request): array;
    public function deleteEmployee(int $peopleId): bool;
    public function getAllEmployees(int $workshopId): array;
    public function getEmployeeById(int $employeeId, int $mechanical_id): ?array;
}
