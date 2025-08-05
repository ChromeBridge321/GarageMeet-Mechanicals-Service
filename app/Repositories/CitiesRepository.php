<?php

namespace App\Repositories;

use App\Contracts\Repositories\CitiesRepositoryInterface;
use App\Models\Cities;

class CitiesRepository implements CitiesRepositoryInterface
{

    public function findByName($name): array
    {
        $cities = Cities::with('state')
            ->where('name', 'LIKE',  $name . '%')
            ->take(20)
            ->get()
            ->map(function ($city) {
                return [
                    'cities_id' => $city->cities_id,
                    'states_id' => $city->states_id,
                    'name' => $city->name. ', ' . ($city->state ? $city->state->name : null),
                ];
            })
            ->toArray();

        return $cities;
    }
}
