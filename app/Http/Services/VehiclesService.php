<?php

namespace App\Http\Services;

use App\Models\Vehicles;

class VehiclesService
{
    public function create(array $data)
    {
        $vehicle = Vehicles::create($data);
        $vehicle = [
            'vehicles_id' => $vehicle->vehicles_id,
            'clients_id' => $vehicle->clients_id,
            'plates' => $vehicle->plates,
            'makes_model_id' => $vehicle->makes_model_id,

        ];
        return $vehicle;
    }

    public function update(array $data)
    {
        $vehicle = Vehicles::findOrFail($data['vehicles_id']);
        $vehicle->update($data);
        $vehicle = [
            'vehicles_id' => $vehicle->vehicles_id,
            'clients_id' => $vehicle->clients_id,
            'plates' => $vehicle->plates,
            'model' => $vehicle->model,
            'make' => $vehicle->make,
        ];
        return $vehicle;
    }

    public function parseCreateData($data, $clients_id)
    {
        $vehicle = [
            'clients_id' => $clients_id,
            'plates' => $data['plates'],
            'makes_model_id' => $data['makes_model_id'],
        ];

        return $vehicle;
    }

    public function parseUpdateData($data, $clients_id)
    {
        $vehicle = [
            'vehicles_id' => $data['vehicles_id'],
            'clients_id' => $clients_id,
            'plates' => $data['plates'],
            'model' => $data['model'],
            'make' => $data['make']
        ];
        return $vehicle;
    }
}
