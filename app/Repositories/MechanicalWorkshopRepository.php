<?php

namespace App\Repositories;

use App\Contracts\Repositories\MechanicalWorkshopRepositoryInterface;
use App\Models\Mechanicals;
use Illuminate\Support\Facades\DB;

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
        $results = DB::select('
            SELECT mw.id, mw.users_id, mw.cities_id, mw.states_id, mw.name, mw.cellphone_number, mw.email, mw.address, mw.google_maps_link,
                   s.states_id as state_id, s.name as state_name, c.cities_id as city_id, c.name as city_name
            FROM cities AS c
            INNER JOIN states AS s ON s.states_id = c.states_id
            INNER JOIN mechanical_workshops AS mw ON mw.states_id = s.states_id AND mw.cities_id = c.cities_id
            WHERE mw.states_id = ? AND mw.cities_id = ?
        ', [$state, $city]);

        return array_map(function ($item) {
            return [
                'id' => $item->id,
                'users_id' => $item->users_id,
                'cities_id' => $item->cities_id,
                'states_id' => $item->states_id,
                'name' => $item->name,
                'cellphone_number' => $item->cellphone_number,
                'email' => $item->email,
                'address' => $item->address,
                'google_maps_link' => $item->google_maps_link,
                'state' => [
                    'states_id' => $item->state_id,
                    'name' => $item->state_name,
                ],
                'city' => [
                    'cities_id' => $item->city_id,
                    'name' => $item->city_name,
                ]
            ];
        }, $results);
    }
}
