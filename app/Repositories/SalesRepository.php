<?php

namespace App\Repositories;

use App\Contracts\Repositories\SalesRepositoryInterface;
use App\Models\Services_sales;
use App\Models\Services_by_sales;
use App\Models\pieces_sales;

class SalesRepository implements SalesRepositoryInterface
{
    public function create(array $data): array
    {
        $service = [
            'payment_types_id' => $data['payment_types_id'],
            'employees_id' => $data['employees_id'],
            'vehicles_id' => $data['vehicles_id'],
            'mechanical_workshops_id' => $data['mechanical_workshops_id'],
            'date' => $data['date'],
            'price' => $data['price'],
        ];

        $sale = Services_sales::create($service);

        foreach ($data['services'] as $serviceId) {
            Services_by_sales::create([
                'services_sales_id' => $sale->services_sales_id,
                'services_id' => $serviceId,
            ]);
        }

        foreach ($data['pieces'] as $pieceId) {
            pieces_sales::create([
                'services_sales_id' => $sale->services_sales_id,
                'pieces_id' => $pieceId,
            ]);
        }

        return [
            'services_sales_id' => $sale->services_sales_id,
            'payment_types_id' => $sale->payment_types_id,
            'employees_id' => $sale->employees_id,
            'vehicles_id' => $sale->vehicles_id,
            'mechanical_workshops_id' => $sale->mechanical_workshops_id,
            'date' => $sale->date,
            'price' => $sale->price,
            'services' => $data['services'],
            'pieces' => $data['pieces'],
        ];
    }

    public function update(int $id, array $data): array
    {
        $service = [
            'payment_types_id' => $data['payment_types_id'],
            'employees_id' => $data['employees_id'],
            'vehicles_id' => $data['vehicles_id'],
            'mechanical_workshops_id' => $data['mechanical_workshops_id'],
            'date' => $data['date'],
            'price' => $data['price'],
        ];
        $sale = Services_sales::findOrFail($id);
        $sale->update($service);
        Services_by_sales::where('services_sales_id', $id)->delete();
        pieces_sales::where('services_sales_id', $id)->delete();

        foreach ($data['services'] as $serviceId) {
            Services_by_sales::create([
                'services_sales_id' => $sale->services_sales_id,
                'services_id' => $serviceId,
            ]);
        }

        foreach ($data['pieces'] as $pieceId) {
            pieces_sales::create([
                'services_sales_id' => $sale->services_sales_id,
                'pieces_id' => $pieceId,
            ]);
        }

        return [
            'services_sales_id' => $sale->services_sales_id,
            'payment_types_id' => $sale->payment_types_id,
            'employees_id' => $sale->employees_id,
            'vehicles_id' => $sale->vehicles_id,
            'mechanical_workshops_id' => $sale->mechanical_workshops_id,
            'date' => $sale->date,
            'price' => $sale->price,
            'services' => $data['services'],
            'pieces' => $data['pieces'],
        ];
    }

    public function findById(int $id, int $mechanical_id): ?array
    {
        $sale = Services_sales::where('services_sales_id', $id)
            ->where('mechanical_workshops_id', $mechanical_id)
            ->with([
                'pieces.piece',  // Cargar las piezas con sus detalles
                'services.service'  // Cargar los servicios con sus detalles
            ])
            ->first();

        if (!$sale) {
            return null;
        }

        // Formatear las piezas con ID y nombre
        $pieces = $sale->pieces->map(function ($pieceSale) {
            return [
                'pieces_id' => $pieceSale->piece->pieces_id,
                'name' => $pieceSale->piece->name,
                'price' => $pieceSale->piece->price
            ];
        });

        // Formatear los servicios con ID y nombre
        $services = $sale->services->map(function ($serviceSale) {
            return [
                'services_id' => $serviceSale->service->services_id,
                'name' => $serviceSale->service->name
            ];
        });

        return [
            'services_sales_id' => $sale->services_sales_id,
            'payment_types_id' => $sale->payment_types_id,
            'employees_id' => $sale->employees_id,
            'vehicles_id' => $sale->vehicles_id,
            'mechanical_workshops_id' => $sale->mechanical_workshops_id,
            'date' => $sale->date,
            'price' => $sale->price,
            'pieces' => $pieces->toArray(),
            'services' => $services->toArray()
        ];
    }

    public function delete(int $id): bool
    {
        $sale = Services_sales::findOrFail($id);
        return $sale->delete();
    }

    public function getAllByWorkshop(int $workshopId): array
    {
        $sales = Services_sales::where('mechanical_workshops_id', $workshopId)
            ->with([
                'pieces.piece',  // Cargar las piezas con sus detalles
                'services.service'  // Cargar los servicios con sus detalles
            ])
            ->get();

        return $sales->map(function ($sale) {
            // Formatear las piezas con ID y nombre
            $pieces = $sale->pieces->map(function ($pieceSale) {
                return [
                    'pieces_id' => $pieceSale->piece->pieces_id,
                    'name' => $pieceSale->piece->name,
                    'price' => $pieceSale->piece->price
                ];
            });

            // Formatear los servicios con ID y nombre
            $services = $sale->services->map(function ($serviceSale) {
                return [
                    'services_id' => $serviceSale->service->services_id,
                    'name' => $serviceSale->service->name
                ];
            });

            return [
                'services_sales_id' => $sale->services_sales_id,
                'payment_types_id' => $sale->payment_types_id,
                'employees_id' => $sale->employees_id,
                'vehicles_id' => $sale->vehicles_id,
                'mechanical_workshops_id' => $sale->mechanical_workshops_id,
                'date' => $sale->date,
                'price' => $sale->price,
                'pieces' => $pieces->toArray(),
                'services' => $services->toArray()
            ];
        })->toArray();
    }
}
