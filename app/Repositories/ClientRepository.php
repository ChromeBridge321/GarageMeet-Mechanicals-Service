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

    public function findById(int $client_id, int $mechanical_id): ?array
    {
        $client = clients::with(['person', 'vehicles'])
            ->where('clients_id', $client_id)
            ->where('mechanical_workshops_id', $mechanical_id)
            ->first()->toArray();


        if (!$client) {
            return [
                'error' => 'Client not found',
            ];
        }

        $clientArray = $client;
        // Agregar nombres de marca y modelo a los vehículos
        if (isset($clientArray['vehicles']) && !empty($clientArray['vehicles'])) {
            foreach ($clientArray['vehicles'] as &$vehicle) {

                if (isset($vehicle['makes_model_id'])) {
                    $makeModelInfo = $this->getMakeModelName($vehicle['makes_model_id']);
                    $vehicle['make'] = $makeModelInfo['make'];
                    $vehicle['model'] = $makeModelInfo['model'];
                }
            }
        }

        return $clientArray;

    }
    public function delete(int $id): bool
    {
        $client = clients::findOrFail($id);
        return $client->delete();
    }

    public function getAllByWorkshop(int $workshopId): array
    {
        $clients = clients::with(['person', 'vehicles'])
            ->where('mechanical_workshops_id', $workshopId)
            ->get()
            ->toArray();

        // Agregar nombres de marca y modelo a cada cliente
        foreach ($clients as &$client) {
            if (isset($client['vehicles']) && !empty($client['vehicles'])) {
                foreach ($client['vehicles'] as &$vehicle) {
                    if (isset($vehicle['makes_model_id'])) {
                        $makeModelInfo = $this->getMakeModelName($vehicle['makes_model_id']);
                        $vehicle['make'] = $makeModelInfo['make'];
                        $vehicle['model'] = $makeModelInfo['model'];
                    }
                }
            }
        }

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

}
