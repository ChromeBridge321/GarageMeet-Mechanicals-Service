<?php

namespace App\Repositories;

use App\Contracts\Repositories\ServicesRepositoryInterface;
use App\Models\Services;

class ServicesRepository implements ServicesRepositoryInterface
{
    public function create(array $data): array
    {
        $service = Services::create($data);

        return [
            'services_id' => $service->services_id,
            'name' => $service->name,
            'mechanical_workshops_id' => $service->mechanical_workshops_id,
        ];
    }

    public function update(int $id, array $data): array
    {
        $service = Services::findOrFail($id);
        $service->update($data);

        return [
            'services_id' => $service->services_id,
            'name' => $service->name,
            'mechanical_workshops_id' => $service->mechanical_workshops_id,
        ];
    }

    public function findById(int $id, int $mechanical_id): ?array
    {
        $service = Services::where('services_id', $id)
            ->where('mechanical_workshops_id', $mechanical_id)
            ->first();

        if (!$service) {
            return [];
        }

        return [
            'services_id' => $service->services_id,
            'name' => $service->name,
            'mechanical_workshops_id' => $service->mechanical_workshops_id,
        ];
    }

    public function delete(int $id): bool
    {
        $service = Services::findOrFail($id);
        return $service->delete();
    }

    public function getAllByWorkshop(int $workshopId): array
    {
        $services = Services::where('mechanical_workshops_id', $workshopId)
            ->get()->toArray();
        return $services;
    }
}
