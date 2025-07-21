<?php

namespace App\Repositories;

use App\Contracts\Repositories\VehiclesRepositoryInterface;
use App\Models\Models;
use App\Models\Makes;
use App\Models\MakeModel;

class VehiclesRepository implements VehiclesRepositoryInterface
{
    public function getAllModels(): array
    {
        return Models::all()->take(50)->toArray();
    }

    public function getAllMakes(): array
    {
        return Makes::all()->take(50)->toArray();
    }

    public function getModelByName(string $name): array
    {
        return Models::where('name', 'like', '%' . $name . '%')->get()->take(10)->toArray();
    }

    public function getMakeByName(string $name): array
    {
        return Makes::where('name', 'like', '%' . $name . '%')->get()->take(10)->toArray();
    }

    public function getModelsByMakeId(int $makeId): array
    {
        $make = Makes::find($makeId);
        $models = $make->models()->withPivot('makes_model_id')->get();
        $formattedModels = $models->map(function ($model) {
            return [
                'model_id' => $model->model_id,
                'name' => $model->name,
                'makes_model_id' => $model->pivot->makes_model_id
            ];
        });

        return [
            'make' => $make,
            'models' => $formattedModels
        ];
    }

    public function getModelMakeByMakesModelId(int $makesModelId): array
    {
        $makeModel = MakeModel::find($makesModelId);
        $make = $makeModel->make;
        $model = $makeModel->model;

        return [
            'make' => [
                'make_id' => $make->make_id,
                'name' => $make->name
            ],
            'model' => [
                'model_id' => $model->model_id,
                'name' => $model->name
            ]
        ];
    }
}
