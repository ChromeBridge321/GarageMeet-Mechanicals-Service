<?php

namespace App\Repositories;

use App\Contracts\Repositories\PaymentTypesRepositoryInterface;
use App\Models\Payment_types as PaymentTypes;

class PaymentTypesRepository implements PaymentTypesRepositoryInterface
{
    public function create(array $data): array
    {
        $paymentType = PaymentTypes::create($data);

        return [
            'payment_types_id' => $paymentType->payment_types_id,
            'name' => $paymentType->name,
            'mechanical_workshops_id' => $paymentType->mechanical_workshops_id,
        ];
    }

    public function update(int $id, array $data): array
    {
        $paymentType = PaymentTypes::findOrFail($id);
        $paymentType->update($data);

        return [
            'payment_types_id' => $paymentType->payment_types_id,
            'name' => $paymentType->name,
            'mechanical_workshops_id' => $paymentType->mechanical_workshops_id,
        ];
    }

    public function findById(int $id, int $mechanical_id): ?array
    {
        $paymentType = PaymentTypes::where('payment_types_id', $id)
            ->where('mechanical_workshops_id', $mechanical_id)
            ->first();

        if (!$paymentType) {
            return [];
        }

        return [
            'payment_types_id' => $paymentType->payment_types_id,
            'name' => $paymentType->name,
            'mechanical_workshops_id' => $paymentType->mechanical_workshops_id,
        ];
    }

    public function delete(int $id): bool
    {
        $paymentType = PaymentTypes::findOrFail($id);
        return $paymentType->delete();
    }

    public function getAllByWorkshop(int $workshopId): array
    {
        $paymentTypes = PaymentTypes::where('mechanical_workshops_id', $workshopId)
            ->get()->toArray();
        return $paymentTypes;
    }
}
