<?php

namespace App\Repositories;

use App\Contracts\Repositories\ClientRepositoryInterface;
use App\Models\clients;
use App\Models\MakeModel;

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
        $clients =  clients::with(['person', 'vehicles'])
            ->where('mechanical_workshops_id', $workshopId)
            ->get()
            ->toArray();
        $makeModelNames = $this->getMakeModelName($clients[0]['vehicles'][0]['makes_model_id']);
        $clients = $this->ParseAllClientsData($clients, $makeModelNames['make'], $makeModelNames['model']);
        return $clients;
    }

    private function getMakeModelName(int $makeModelId): array
    {
        $makeModel = MakeModel::find($makeModelId);
        if (!$makeModel) {
            return ['make' => null, 'model' => null];
        }
        return [
            'make' => $makeModel->make->name,
            'model' => $makeModel->model->name,
        ];
    }


    private function ParseAllClientsData($clients, $make, $model): array
    {
        return [
            'clients_id' => $clients[0]['clients_id'],
            'peoples_id' => $clients[0]['clients_id'],
            'person' => [
                'peoples_id' => $clients[0]['person']['peoples_id'],
                'name' => $clients[0]['person']['name'],
                'last_name' => $clients[0]['person']['last_name'],
                'email' => $clients[0]['person']['email'],
                'cellphone_number' => $clients[0]['person']['cellphone_number'],
            ],
            'vehicles' => [
                [
                    'vehicles_id' => $clients[0]['vehicles'][0]['vehicles_id'],
                    'plates' => $clients[0]['vehicles'][0]['plates'],
                    'makes_model_id' => $clients[0]['vehicles'][0]['makes_model_id'],
                    'make' => $make,
                    'model' => $model,
                ]
            ],
        ];
    }
}
