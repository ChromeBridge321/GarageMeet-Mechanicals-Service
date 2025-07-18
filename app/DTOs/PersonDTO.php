<?php

namespace App\DTOs;

class PersonDTO
{
    public function __construct(
        public readonly ?int $peoplesId,
        public readonly string $name,
        public readonly string $lastName,
        public readonly string $email,
        public readonly string $cellphoneNumber
    ) {}

    public function toArray(): array
    {
        return [
            'peoples_id' => $this->peoplesId,
            'name' => $this->name,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'cellphone_number' => $this->cellphoneNumber,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            peoplesId: $data['peoples_id'] ?? null,
            name: $data['name'],
            lastName: $data['last_name'],
            email: $data['email'],
            cellphoneNumber: $data['cellphone_number']
        );
    }
}
