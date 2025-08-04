<?php

namespace App\Repositories;

use App\Contracts\Repositories\MechanicalWorkshopRepositoryInterface;
use App\Models\Mechanicals;

class MechanicalWorkshopRepository implements MechanicalWorkshopRepositoryInterface
{
    public function create(array $data): array
    {
        $workshop = Mechanicals::create($data);

        return [
            'id' => $workshop->id,
            'users_id' => $workshop->users_id,
            'cities_id' => $workshop->cities_id,
            'states_id' => $workshop->states_id,
            'name' => $workshop->name,
            'cellphone_number' => $workshop->cellphone_number,
            'email' => $workshop->email,
            'address' => $workshop->address,
            'google_maps_link' => $workshop->google_maps_link,
        ];
    }

    public function update(int $id, array $data): array
    {
        $workshop = Mechanicals::findOrFail($id);
        $workshop->update($data);

        return [
            'id' => $workshop->id,
            'users_id' => $workshop->users_id,
            'cities_id' => $workshop->cities_id,
            'states_id' => $workshop->states_id,
            'name' => $workshop->name,
            'cellphone_number' => $workshop->cellphone_number,
            'email' => $workshop->email,
            'address' => $workshop->address,
            'google_maps_link' => $workshop->google_maps_link,
        ];
    }

    public function findById(int $id): ?array
    {
        $workshop = Mechanicals::find($id);

        if (!$workshop) {
            return null;
        }

        return [
            'id' => $workshop->id,
            'users_id' => $workshop->users_id,
            'cities_id' => $workshop->cities_id,
            'states_id' => $workshop->states_id,
            'name' => $workshop->name,
            'cellphone_number' => $workshop->cellphone_number,
            'email' => $workshop->email,
            'address' => $workshop->address,
            'google_maps_link' => $workshop->google_maps_link,
        ];
    }

    public function delete(int $id): bool
    {
        $workshop = Mechanicals::findOrFail($id);
        return $workshop->delete();
    }

    public function getAllByUser(int $userId): array
    {
        return Mechanicals::where('users_id', $userId)
            ->get()
            ->toArray();
    }

    public function getAll(): array
    {
        return Mechanicals::all()->toArray();
    }

    public function getAllByState(string $state): array
    {
        return Mechanicals::where('states_id', $state)
            ->get()
            ->toArray();
    }
    public function getAllByStateAndCity(string $state, string $city): array
    {
        return Mechanicals::where('states_id', $state)
            ->where('cities_id', $city)
            ->get()
            ->toArray();
    }
}
