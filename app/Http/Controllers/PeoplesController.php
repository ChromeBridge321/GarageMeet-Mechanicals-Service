<?php

namespace App\Http\Controllers;

use App\Contracts\Services\PeopleServiceInterface;
use App\Http\Requests\StorePeoplesRequest;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;

class PeoplesController extends Controller
{
    private PeopleServiceInterface $peopleService;

    public function __construct(PeopleServiceInterface $peopleService)
    {
        $this->peopleService = $peopleService;
    }

    public function create(StorePeoplesRequest $request)
    {
        try {
            $data = $request->validated();
            $person = $this->peopleService->createPerson($data);
            return ApiResponse::created('Person created successfully', $person);
        } catch (\Exception $e) {
            return ApiResponse::error('Error creating person', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $person = $this->peopleService->updatePerson($id, $request->all());
            return ApiResponse::success('Person updated successfully', $person);
        } catch (\Exception $e) {
            return ApiResponse::error('Error updating person', $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $person = $this->peopleService->findPerson($id);

            if (!$person) {
                return ApiResponse::notFound('Person not found');
            }

            return response()->json($person);
        } catch (\Exception $e) {
            return ApiResponse::error('Error retrieving person', $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $this->peopleService->deletePerson($id);
            return ApiResponse::success('Person deleted successfully');
        } catch (\Exception $e) {
            return ApiResponse::error('Error deleting person', $e->getMessage());
        }
    }
}
