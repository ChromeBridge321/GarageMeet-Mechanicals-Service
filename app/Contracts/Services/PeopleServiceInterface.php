<?php

namespace App\Contracts\Services;

use App\Http\Requests\StorePeoplesRequest;

interface PeopleServiceInterface
{
    public function createPerson(array $data): array;
    public function updatePerson(int $id, array $data): array;
    public function findPerson(int $id): ?array;
    public function deletePerson(int $id): bool;
}
