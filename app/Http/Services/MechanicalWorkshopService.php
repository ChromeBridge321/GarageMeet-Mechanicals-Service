<?php

namespace App\Http\Services;

use App\Models\Mechanicals;

class MechanicalWorkshopService
{
    public function create(array $data)
    {
        $mechanical = Mechanicals::create($data);
        $mechanical = [
            'id' => $mechanical->id,
            'users_id' => $mechanical->users_id,
            'cities_id' => $mechanical->cities_id,
            'name' => $mechanical->name,
            'cellphone_number' => $mechanical->cellphone_number,
            'email' => $mechanical->email,
            'address' => $mechanical->address,
            'google_maps_link' => $mechanical->google_maps_link,
        ];
        return $mechanical;
    }

    public function update(array $data)
    {
        $mechanical = Mechanicals::findOrFail($data['id']);
        $mechanical->update($data);
                $mechanical = [
            'id' => $mechanical->id,
            'users_id' => $mechanical->users_id,
            'cities_id' => $mechanical->cities_id,
            'name' => $mechanical->name,
            'cellphone_number' => $mechanical->cellphone_number,
            'email' => $mechanical->email,
            'address' => $mechanical->address,
            'google_maps_link' => $mechanical->google_maps_link,
        ];
        return $mechanical;
    }
}
