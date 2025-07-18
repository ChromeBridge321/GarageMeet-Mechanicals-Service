<?php

namespace App\DTOs;

class MechanicalWorkshopDTO
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $usersId,
        public readonly int $citiesId,
        public readonly string $name,
        public readonly string $cellphoneNumber,
        public readonly string $email,
        public readonly string $address,
        public readonly ?string $googleMapsLink = null
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'users_id' => $this->usersId,
            'cities_id' => $this->citiesId,
            'name' => $this->name,
            'cellphone_number' => $this->cellphoneNumber,
            'email' => $this->email,
            'address' => $this->address,
            'google_maps_link' => $this->googleMapsLink,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            usersId: $data['users_id'],
            citiesId: $data['cities_id'],
            name: $data['name'],
            cellphoneNumber: $data['cellphone_number'],
            email: $data['email'],
            address: $data['address'],
            googleMapsLink: $data['google_maps_link'] ?? null
        );
    }
}
