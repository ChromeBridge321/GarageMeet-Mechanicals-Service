<?php

namespace App\Contracts\Services;

use App\Http\Requests\StorePeoplesRequest;
use App\Http\Requests\UpdatePeoplesRequest;

interface ClientServiceInterface
{
    public function createClient(StorePeoplesRequest $request): array;
    public function updateClient(UpdatePeoplesRequest $request): array;
    public function deleteClient(int $peopleId): bool;
    public function getAllClients(int $workshopId): array;
}
