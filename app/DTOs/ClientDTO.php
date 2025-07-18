<?php

namespace App\DTOs;

class ClientDTO
{
    public function __construct(
        public readonly ?int $clientsId,
        public readonly int $mechanicalWorkshopsId,
        public readonly int $peoplesId
    ) {}

    public function toArray(): array
    {
        return [
            'clients_id' => $this->clientsId,
            'mechanical_workshops_id' => $this->mechanicalWorkshopsId,
            'peoples_id' => $this->peoplesId,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            clientsId: $data['clients_id'] ?? null,
            mechanicalWorkshopsId: $data['mechanical_workshops_id'],
            peoplesId: $data['peoples_id']
        );
    }
}
