<?php
namespace App\Http\Controllers;
use App\Http\Responses\ApiResponse;
use App\Contracts\Services\VehiclesServiceInterface;


class VehiclesController extends Controller
{
    private VehiclesServiceInterface $vehiclesService;

    public function __construct(VehiclesServiceInterface $vehiclesService)
    {
        $this->vehiclesService = $vehiclesService;
    }

    public function getAllModels(){
        try {
            $vehicles = $this->vehiclesService->AllModels();
            return response()->json($vehicles);
        } catch (\Exception $e) {
            return ApiResponse::error('Error retrieving vehicles', $e->getMessage());
        }
    }

    public function getAllMakes(){
        try {
            $vehicles = $this->vehiclesService->AllMakes();
            return response()->json($vehicles);
        } catch (\Exception $e) {
            return ApiResponse::error('Error retrieving vehicles', $e->getMessage());
        }
    }


    public function getModelByName(string $name){
        try {
            $vehicles = $this->vehiclesService->ModelByName($name);
            return response()->json($vehicles);
        } catch (\Exception $e) {
            return ApiResponse::error('Error retrieving vehicle model', $e->getMessage());
        }
    }


    public function getMakeByName(string $name){
        try {
            $vehicles = $this->vehiclesService->MakeByName($name);
            return response()->json($vehicles);
        } catch (\Exception $e) {
            return ApiResponse::error('Error retrieving vehicle make', $e->getMessage());
        }
    }

    public function getModelsByMakeId(int $makeId){
        try {
            $vehicles = $this->vehiclesService->ModelsByMakeId($makeId);
            return response()->json($vehicles);
        } catch (\Exception $e) {
            return ApiResponse::error('Error retrieving vehicle models by make ID', $e->getMessage());
        }
    }

    public function getModelMakeByMakesModelId(int $makesModelId){
        try {
            $vehicles = $this->vehiclesService->ModelMakeByMakesModelId($makesModelId);
            return response()->json($vehicles);
        } catch (\Exception $e) {
            return ApiResponse::error('Error retrieving vehicle model make by makes model ID', $e->getMessage());
        }
    }

}
