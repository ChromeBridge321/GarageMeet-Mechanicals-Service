<?php

namespace App\Services;
use App\Contracts\Repositories\PaymentTypesRepositoryInterface;
use App\Contracts\Services\PaymentTypesServiceInterface;

class PaymentTypesService implements PaymentTypesServiceInterface
{
    private PaymentTypesRepositoryInterface $paymentTypesRepository;

    public function __construct(PaymentTypesRepositoryInterface $paymentTypesRepository)
    {
        $this->paymentTypesRepository = $paymentTypesRepository;
    }

    public function createPaymentType(array $data): array
    {
        return $this->paymentTypesRepository->create($data);
    }

    public function updatePaymentType(int $id, array $data): array
    {
        return $this->paymentTypesRepository->update($id, $data);
    }

    public function deletePaymentType(int $id): bool
    {
        return $this->paymentTypesRepository->delete($id);
    }

    public function getAllPaymentTypes(int $workshopId): array
    {
        return $this->paymentTypesRepository->getAllByWorkshop($workshopId);
    }

    public function findPaymentType(int $id, int $mechanical_id): ?array
    {
        return $this->paymentTypesRepository->findById($id, $mechanical_id);
    }
}
