<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePeoplesRequest;
use App\Http\Services\PeoplesService;
use App\Models\Peoples;
use Illuminate\Http\Request;

class PeoplesController extends Controller
{
    protected $peoplesService;

    public function __construct(PeoplesService $peoplesService)
    {
        $this->peoplesService = $peoplesService;
    }
    public function create(StorePeoplesRequest $request)
    {
        // Logic to handle creating a new person
        // This could involve validating the request, creating a new person, etc.
        $data = $request->validated();
        $person = $this->peoplesService->create($data);

        return response()->json(['message' => 'Person created successfully', 'data' => $person], 201);
    }

    public function update(Request $request, $id)
    {
        // Logic to handle updating an existing person
        // This could involve validating the request, finding the person by ID, updating their details, etc.

        return response()->json(['message' => 'Person updated successfully'], 200);
    }
}
