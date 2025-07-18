<?php

namespace App\Repositories;

use App\Contracts\Repositories\PeopleRepositoryInterface;
use App\Models\Peoples;

class PeopleRepository implements PeopleRepositoryInterface
{
    public function create(array $data): array
    {
        $person = Peoples::create($data);

        return [
            'peoples_id' => $person->peoples_id,
            'name' => $person->name,
            'last_name' => $person->last_name,
            'email' => $person->email,
            'cellphone_number' => $person->cellphone_number,
        ];
    }

    public function update(int $id, array $data): array
    {
        $person = Peoples::findOrFail($id);
        $person->update($data);

        return [
            'peoples_id' => $person->peoples_id,
            'name' => $person->name,
            'last_name' => $person->last_name,
            'email' => $person->email,
            'cellphone_number' => $person->cellphone_number,
        ];
    }

    public function findById(int $id): ?array
    {
        $person = Peoples::find($id);

        if (!$person) {
            return null;
        }

        return [
            'peoples_id' => $person->peoples_id,
            'name' => $person->name,
            'last_name' => $person->last_name,
            'email' => $person->email,
            'cellphone_number' => $person->cellphone_number,
        ];
    }

    public function delete(int $id): bool
    {
        $person = Peoples::findOrFail($id);
        return $person->delete();
    }
}
