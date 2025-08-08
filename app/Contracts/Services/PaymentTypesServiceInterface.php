<?php

namespace App\Contracts\Services;

use Illuminate\Http\Request;

interface PaymentTypesServiceInterface
{
    public function createPaymentType(array $data): array;
    public function updatePaymentType(int $id, array $data): array;
    public function deletePaymentType(int $id): bool;
    public function getAllPaymentTypes(int $workshopId): array;
    public function findPaymentType(int $id, int $mechanical_id): ?array;
}
