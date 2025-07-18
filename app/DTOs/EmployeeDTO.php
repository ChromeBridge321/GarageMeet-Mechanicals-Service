<?php

namespace App\DTOs;

class EmployeeDTO
{
    public function __construct(
        public readonly ?int $employeesId,
        public readonly int $mechanicalWorkshopsId,
        public readonly int $peoplesId
    ) {}

    public function toArray(): array
    {
        return [
            'employees_id' => $this->employeesId,
            'mechanical_workshops_id' => $this->mechanicalWorkshopsId,
            'peoples_id' => $this->peoplesId,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            employeesId: $data['employees_id'] ?? null,
            mechanicalWorkshopsId: $data['mechanical_workshops_id'],
            peoplesId: $data['peoples_id']
        );
    }
}
