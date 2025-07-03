<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePeoplesRequest;
use App\Http\Requests\UpdatePeoplesRequest;
use App\Http\Services\ClientsService;
use Illuminate\Http\Request;
use App\Http\Services\PeoplesService;
use App\Http\Services\VehiclesService;
use Illuminate\Http\Response;

class ClientsController extends Controller
{
    protected $peoplesService;
    protected $clientsService;
    protected $vehiclesService;

    public function __construct(PeoplesService $peoplesService, ClientsService $clientsService, VehiclesService $vehiclesService)
    {
        $this->peoplesService = $peoplesService;
        $this->clientsService = $clientsService;
        $this->vehiclesService = $vehiclesService;
    }

    public function create(StorePeoplesRequest $request)
    {
        $person = $this->peoplesService->create($request->validated());
        $client = $this->clientsService->parseCreateData($request, $person);
        $client = $this->clientsService->create($client);
        $vehicle = $request['vehicle'][0];
        $vehicle = $this->vehiclesService->parseCreateData($vehicle, $client['clients_id']);
        $vehicle = $this->vehiclesService->create($vehicle);

        return response()->json([
            'message' => 'Client created successfully',
            'Person' => $person,
            'Client' => $client,
            'Vehicle' => $vehicle
        ], Response::HTTP_CREATED);
    }

    public function update(UpdatePeoplesRequest $request)
    {

        $person = $this->peoplesService->update($request->validated());
        $vehicle = $request['vehicle'][0];
        $vehicle = $this->vehiclesService->parseUpdateData($vehicle, $request['clients_id']);
        $vehicle = $this->vehiclesService->update($vehicle);

        return response()->json([
            'message' => 'Client updated successfully',
            'Person' => $person,
            'Client_id' => $request['clients_id'],
            'Vehicle' => $vehicle
        ], Response::HTTP_OK);
    }

    public function delete(Request $request)
    {
        $this->clientsService->delete($request['peoples_id'], $request['clients_id']);
        return response()->json([
            'message' => 'Client deleted successfully'
        ], Response::HTTP_OK);
    }

    public function getAll(Request $request)
    {
        $client = $this->clientsService->getAll($request['mechanical_workshops_id']);
        return response()->json($client, Response::HTTP_OK);
    }
}
