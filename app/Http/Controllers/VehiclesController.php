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

        // Obtener todos los modelos que pertenecen a esta marca usando la relación
        $models = $make->models;

        if ($models->isNotEmpty()) {
            return response()->json([
                'make' => $make,
                'models' => $models
            ], 200);
        } else {
            return response()->json(['message' => 'No models found for this make'], 404);
        }
    }
}
