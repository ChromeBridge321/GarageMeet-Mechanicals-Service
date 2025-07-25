<?php

namespace App\Services;

use App\Contracts\Repositories\ClientRepositoryInterface;
use App\Contracts\Repositories\PeopleRepositoryInterface;
use App\Contracts\Repositories\VehiclesClientsRepositoryInterface;
use App\Contracts\Services\ClientServiceInterface;
use App\Http\Requests\StorePeoplesRequest;
use App\Http\Requests\UpdatePeoplesRequest;
use Illuminate\Support\Facades\DB;

class ClientService implements ClientServiceInterface
{
    private PeopleRepositoryInterface $peopleRepository;
    private ClientRepositoryInterface $clientRepository;
    private VehiclesClientsRepositoryInterface $vehicleRepository;

    public function __construct(
        PeopleRepositoryInterface $peopleRepository,
        ClientRepositoryInterface $clientRepository,
        VehiclesClientsRepositoryInterface $vehicleRepository
    ) {
        $this->peopleRepository = $peopleRepository;
        $this->clientRepository = $clientRepository;
        $this->vehicleRepository = $vehicleRepository;
    }

    public function createClient(StorePeoplesRequest $request): array
    {

        return DB::transaction(function () use ($request) {
            $validatedData = $request->validated();

            // Create person
            $person = $this->peopleRepository->create($validatedData);
            $makeModelId = $this->vehicleRepository->getMakeModelId(
                $request['vehicle'][0]['make_id'],
                $request['vehicle'][0]['model_id']
            );

            // Create client
            $clientData = [
                'mechanical_workshops_id' => $request['mechanicals_id'],
                'peoples_id' => $person['peoples_id'],
            ];
            $client = $this->clientRepository->create($clientData);

            // Create vehicle
            $vehicleData = $request['vehicle'][0];
            $vehicleCreateData = [
                'clients_id' => $client['clients_id'],
                'plates' => $vehicleData['plates'],
                'makes_model_id' => $makeModelId,
            ];
            $vehicle = $this->vehicleRepository->create($vehicleCreateData);

            return [
                'person' => $person,
                'client' => $client,
                'vehicle' => $vehicle
            ];
        });
    }

    public function updateClient(UpdatePeoplesRequest $request): array
    {
        return DB::transaction(function () use ($request) {
            $validatedData = $request->validated();

            // Update person
            $person = $this->peopleRepository->update($validatedData['peoples_id'], $validatedData);


            // Update vehicle
            $vehicleData = $request['vehicle'][0];
            $makeModelId = $this->vehicleRepository->getMakeModelId(
                $vehicleData['make_id'],
                $vehicleData['model_id']
            );
            $vehicle = $this->vehicleRepository->update($vehicleData['vehicles_id'], [
                'plates' => $vehicleData['plates'],
                'makes_model_id' => $makeModelId,
            ]);

            return [
                'person' => $person,
                'client_id' => $request['clients_id'],
                'vehicle' => $vehicle
            ];
        });
    }

    public function deleteClient(int $peopleId): bool
    {
        return DB::transaction(function () use ($peopleId) {
            //$this->clientRepository->delete($clientId);
            return $this->peopleRepository->delete($peopleId);
        });
    }

    public function getAllClients(int $workshopId): array
    {
        return $this->clientRepository->getAllByWorkshop($workshopId);
    }

    public function getClientById(int $client_id, int $mechanical_id): ?array
    {
        return $this->clientRepository->findById($client_id, $mechanical_id);
    }
}
