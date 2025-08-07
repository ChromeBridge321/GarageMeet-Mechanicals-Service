<?php

namespace App\Repositories;

use App\Contracts\Repositories\CitiesRepositoryInterface;
use App\Models\Cities;

class CitiesRepository implements CitiesRepositoryInterface
{

    public function findByName($name): array
    {
        $CitiesMap = [];
        $cities = Cities::with('state:states_id,name')
            ->select('cities_id', 'states_id', 'name')
            ->where('name', 'LIKE', $name . '%')
            ->take(10)
            ->get();

        foreach ($cities as $city) {
            $CitiesMap[] = [
                'cities_id' => $city->cities_id,
                'states_id' => $city->states_id,
                'name' => $city->name . ', ' . ($city->state ? $city->state->name : null),
            ];
        }
        return $CitiesMap;
    }
}
