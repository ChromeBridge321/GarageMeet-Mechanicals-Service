<?php
namespace App\Http\Controllers;
use App\Models\MakeModel;
use App\Models\Makes;
use App\Models\Models;


class VehiclesController extends Controller
{
    public function getAllModels()
    {
        // Logic to retrieve all vehicle models
        $models = Models::all();
        return response()->json($models, 200);
    }
    public function getAllMakes()
    {
        // Logic to retrieve all vehicle makes
        $makes = Makes::all();
        return response()->json($makes, 200);
    }

    public function getModelByName($name)
    {
        // Logic to retrieve a model by its name
        $model = Models::where('name', 'like', '%' . $name . '%')->get();
        if ($model) {
            return response()->json($model, 200);
        } else {
            return response()->json(['message' => 'Model not found'], 404);
        }
    }

    public function getMakeByName($name)
    {
        // Logic to retrieve a make by its name
        $make = Makes::where('name', 'like', '%' . $name . '%')->get();
        if ($make) {
            return response()->json($make, 200);
        } else {
            return response()->json(['message' => 'Make not found'], 404);
        }
    }
public function getModelsByMakeId($makeId)
    {
        // Verificar si la marca existe
        $make = Makes::find($makeId);
        if (!$make) {
            return response()->json(['message' => 'Make not found'], 404);
        }

        // Obtener todos los modelos que pertenecen a esta marca con el makes_model_id
        $models = $make->models()->withPivot('makes_model_id')->get();

        if ($models->isNotEmpty()) {
            // Formatear la respuesta para incluir el makes_model_id
            $formattedModels = $models->map(function ($model) {
                return [
                    'model_id' => $model->model_id,
                    'name' => $model->name,
                    'makes_model_id' => $model->pivot->makes_model_id
                ];
            });

            return response()->json([
                'make' => $make,
                'models' => $formattedModels
            ], 200);
        } else {
            return response()->json(['message' => 'No models found for this make'], 404);
        }
    }

    public function getModelMakeByMakesModelId($makesModelId)
    {
        // Verificar si el makes_model_id existe
        $makeModel = MakeModel::find($makesModelId);
        if (!$makeModel) {
            return response()->json(['message' => 'MakeModel not found'], 404);
        }

        // Obtener la marca y el modelo asociados
        $make = $makeModel->make->name;
        $model = $makeModel->model->name;

        return response()->json([
            'make' => $make,
            'model' => $model
        ], 200);
    }
}
