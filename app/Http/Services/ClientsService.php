<?php

namespace App\Http\Services;

use App\Models\clients;
use App\Models\Peoples;
use Illuminate\Http\Response;

class ClientsService
{
    public function create(array $data)
    {
        $client = clients::create($data);
        $client = [
            'clients_id' => $client->clients_id,
            'mechanical_workshops_id' => $client->mechanical_workshops_id,
            'peoples_id' => $client->peoples_id,
        ];
        return $client;
    }

    public function update(array $data)
    {
        $client = Clients::findOrFail($data['clients_id']);
        $client->update($data);
        $client = [
            'clients_id' => $client->clients_id,
            'mechanical_workshops_id' => $client->mechanical_workshops_id,
            'peoples_id' => $client->peoples_id,
        ];
        return $client;
    }


    public function parseCreateData($data, $person)
    {

        $client = [
            'mechanical_workshops_id' => $data['mechanicals_id'],
            'peoples_id' => $person['peoples_id'],
        ];

        return $client;
    }

    public function parseUpdateData($data)
    {
        $client = [
            'clients_id' => $data['clients_id'],
        ];
        return $client;
    }

    public function delete($peoples_id, $clients_id)
    {
        $person = Peoples::findOrFail($peoples_id);
        $client = clients::findOrFail($clients_id);
        $person->delete();
        $client->delete();
        return response()->json(['message' => 'Client deleted successfully'], Response::HTTP_OK);
    }

    public function getAll($workshopId)
    {
        $clients = clients::with(['person', 'vehicles'])
            ->where('mechanical_workshops_id', $workshopId)
            ->get();
        return $clients;
    }
}
