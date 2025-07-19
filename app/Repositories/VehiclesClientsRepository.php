<?php

namespace App\Repositories;

use App\Contracts\Repositories\VehiclesClientsRepositoryInterface;
use App\Models\Vehicles;

class VehiclesClientsRepository implements VehiclesClientsRepositoryInterface
{
    public function create(array $data): array
    {
        $vehicle = Vehicles::create($data);

        return [
            'vehicles_id' => $vehicle->vehicles_id,
            'clients_id' => $vehicle->clients_id,
            'plates' => $vehicle->plates,
            'makes_model_id' => $vehicle->makes_model_id,
        ];
    }

    public function update(int $id, array $data): array
    {
        $vehicle = Vehicles::findOrFail($id);
        $vehicle->update($data);

        return [
            'vehicles_id' => $vehicle->vehicles_id,
            'clients_id' => $vehicle->clients_id,
            'plates' => $vehicle->plates,
            'makes_model_id' => $vehicle->makes_model_id,
        ];
    }

    public function findById(int $id): ?array
    {
        $vehicle = Vehicles::find($id);

        if (!$vehicle) {
            return null;
        }

        return [
            'vehicles_id' => $vehicle->vehicles_id,
            'clients_id' => $vehicle->clients_id,
            'plates' => $vehicle->plates,
            'makes_model_id' => $vehicle->makes_model_id,
        ];
    }

    public function delete(int $id): bool
    {
        $vehicle = Vehicles::findOrFail($id);
        return $vehicle->delete();
    }

    public function getByClientId(int $clientId): array
    {
        return Vehicles::where('clients_id', $clientId)->get()->toArray();
    }
}
