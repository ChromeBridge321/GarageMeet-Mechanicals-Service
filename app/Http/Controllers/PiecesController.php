<?php

namespace App\Http\Controllers;

use App\Contracts\Services\PiecesServiceInterface;
use App\Http\Requests\StorePieceRequest;
use App\Http\Requests\UpdatePieceRequest;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;

class PiecesController extends Controller
{
    private PiecesServiceInterface $piecesService;

    public function __construct(PiecesServiceInterface $piecesService)
    {
        $this->piecesService = $piecesService;
    }

    public function create(StorePieceRequest $request)
    {
        try {
            $data = $request->validated();
            $piece = $this->piecesService->createPiece($data);
            return ApiResponse::created('Piece created successfully', $piece);
        } catch (\Exception $e) {
            return ApiResponse::error('Error creating piece', $e->getMessage());
        }
    }

    public function update(UpdatePieceRequest $request)
    {
        try {
            $data = $request->validated();
            $piece = $this->piecesService->updatePiece(
                $data['pieces_id'],
                [
                    'name' => $data['name'],
                    'price' => $data['price']
                ]
            );
            return ApiResponse::success('Piece updated successfully', $piece);
        } catch (\Exception $e) {
            return ApiResponse::error('Error updating piece', $e->getMessage());
        }
    }

    public function delete(Request $request)
    {
        try {
            $data = $request->validate([
                'pieces_id' => 'required|exists:pieces,pieces_id',
            ]);

            $this->piecesService->deletePiece($data['pieces_id']);
            return ApiResponse::success('Piece deleted successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return ApiResponse::error('Validation failed', $e->getMessage(), 422);
        } catch (\Exception $e) {
            return ApiResponse::error('Error deleting piece', $e->getMessage());
        }
    }

    public function getAll(Request $request)
    {
        try {
            $data = $request->validate([
                'mechanical_workshops_id' => 'required|exists:mechanical_workshops,id',
            ]);

            $pieces = $this->piecesService->getAllPieces($data['mechanical_workshops_id']);
            return response()->json($pieces);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return ApiResponse::error('Validation failed', $e->getMessage(), 422);
        } catch (\Exception $e) {
            return ApiResponse::error('Error retrieving pieces', $e->getMessage());
        }
    }

    public function getById(Request $request)
    {
        try {
            $piece = $this->piecesService->findPiece($request->pieces_id, $request->mechanical_workshops_id);

            if (!$piece) {
                return ApiResponse::notFound('Piece not found');
            }

            return response()->json($piece);
        } catch (\Exception $e) {
            return ApiResponse::error('Error retrieving piece', $e->getMessage());
        }
    }
}
