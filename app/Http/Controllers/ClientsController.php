<?php

namespace App\Http\Controllers;

use App\Contracts\Services\ClientServiceInterface;
use App\Http\Requests\StorePeoplesRequest;
use App\Http\Requests\UpdatePeoplesRequest;
use App\Http\Responses\ApiResponse;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    private ClientServiceInterface $clientService;

    public function __construct(ClientServiceInterface $clientService)
    {
        $this->clientService = $clientService;
    }

    public function create(StorePeoplesRequest $request)
    {
        try {
            $result = $this->clientService->createClient($request);
            return ApiResponse::created('Client created successfully', $result);
        } catch (\Exception $e) {
            return ApiResponse::error('Error creating client', $e->getMessage());
        }
    }

    public function update(UpdatePeoplesRequest $request)
    {
        try {
            $result = $this->clientService->updateClient($request);
            return ApiResponse::success('Client updated successfully', $result);
        } catch (\Exception $e) {
            return ApiResponse::error('Error updating client', $e->getMessage());
        }
    }

    public function delete(Request $request)
    {
        try {
            $this->clientService->deleteClient(
                $request['peoples_id']
            );
            return ApiResponse::success('Client deleted successfully');
        } catch (\Exception $e) {
            return ApiResponse::error('Error deleting client', $e->getMessage());
        }
    }

    public function getAll(Request $request)
    {
        try {
            $clients = $this->clientService->getAllClients($request['mechanical_workshops_id']);
            return response()->json($clients);
        } catch (\Exception $e) {
            return ApiResponse::error('Error retrieving clients', $e->getMessage());
        }
    }

    public function getById(Request $request)
    {
        try {
            $client = $this->clientService->getClientById(
                $request['client_id'],
                $request['mechanical_workshops_id']
            );
            return response()->json($client);
        } catch (\Exception $e) {
            return ApiResponse::error('Error retrieving client', $e->getMessage());
        }
    }
}
