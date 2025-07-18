<?php

namespace App\Http\Services;
use App\Models\Peoples;

class PeoplesService
{
    public function create(array $data)
    {
        $person = Peoples::create($data);
        $person = [
            'peoples_id' => $person->peoples_id,
            'name' => $person->name,
            'last_name' => $person->last_name,
            'email' => $person->email,
            'cellphone_number' => $person->cellphone_number,
        ];
        return $person;
    }
    public function update(array $data)
    {
        $people = Peoples::findOrFail($data['peoples_id']);
        $people->update($data);
        $people = [
            'peoples_id' => $people->peoples_id,
            'name' => $people->name,
            'last_name' => $people->last_name,
            'email' => $people->email,
            'cellphone_number' => $people->cellphone_number,
        ];
        return $people;
    }
    public function parseCreateData($data, $person)
    {
        $employee = [
            'positions_id' => $data['positions_id'],
            'mechanical_workshops_id' => $data['mechanicals_id'],
            'peoples_id' => $person->peoples_id,
        ];
        return $employee;
    }
    public function parseUpdateData($data)
    {
        $employee = [
            'employees_id' => $data['employees_id'],
            'positions_id' => $data['positions_id'],
        ];
        return $employee;
    }

}
