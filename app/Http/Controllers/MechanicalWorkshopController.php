<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMechanicalsRequest;
use App\Http\Requests\UpdateMechanicalsRequest;
use App\Http\Services\MechanicalWorkshopService;
use Illuminate\Http\Response;

class MechanicalWorkshopController extends Controller
{

    protected $mechanicalService;

    public function __construct(MechanicalWorkshopService $mechanicalService)
    {
        $this->mechanicalService = $mechanicalService;
    }

    public function create(StoreMechanicalsRequest $request)
    {
        $mechanical = $this->mechanicalService->create($request->validated());
        return response()->json([
            'message' => 'Mechanical workshop created successfully',
            'Mechanical workshop' => $mechanical
        ], Response::HTTP_CREATED);
    }

    public function update(UpdateMechanicalsRequest $request)
    {
        $mechanical = $this->mechanicalService->update($request->validated());
        return response()->json([
            'message' => 'Mechanical workshop updated successfully',
            'Mechanical workshop' => $mechanical
        ], Response::HTTP_OK);
    }
}
