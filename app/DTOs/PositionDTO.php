<?php

namespace App\DTOs;

class PositionDTO
{
    public function __construct(
        public readonly ?int $positionsId,
        public readonly string $name,
        public readonly int $mechanicalWorkshopsId
    ) {}

    public function toArray(): array
    {
        return [
            'positions_id' => $this->positionsId,
            'name' => $this->name,
            'mechanical_workshops_id' => $this->mechanicalWorkshopsId,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            positionsId: $data['positions_id'] ?? null,
            name: $data['name'],
            mechanicalWorkshopsId: $data['mechanical_workshops_id']
        );
    }
}
