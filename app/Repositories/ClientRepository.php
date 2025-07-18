<?php

namespace App\Repositories;

use App\Contracts\Repositories\ClientRepositoryInterface;
use App\Models\clients;

class ClientRepository implements ClientRepositoryInterface
{
    public function create(array $data): array
    {
        $client = clients::create($data);

        return [
            'clients_id' => $client->clients_id,
            'mechanical_workshops_id' => $client->mechanical_workshops_id,
            'peoples_id' => $client->peoples_id,
        ];
    }

    public function update(int $id, array $data): array
    {
        $client = clients::findOrFail($id);
        $client->update($data);

        return [
            'clients_id' => $client->clients_id,
            'mechanical_workshops_id' => $client->mechanical_workshops_id,
            'peoples_id' => $client->peoples_id,
        ];
    }

    public function findById(int $id): ?array
    {
        $client = clients::find($id);

        if (!$client) {
            return null;
        }

        return [
            'clients_id' => $client->clients_id,
            'mechanical_workshops_id' => $client->mechanical_workshops_id,
            'peoples_id' => $client->peoples_id,
        ];
    }

    public function delete(int $id): bool
    {
        $client = clients::findOrFail($id);
        return $client->delete();
    }

    public function getAllByWorkshop(int $workshopId): array
    {
        return clients::with(['person', 'vehicles'])
            ->where('mechanical_workshops_id', $workshopId)
            ->get()
            ->toArray();
    }
}
