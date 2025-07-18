<?php

namespace App\Services;

use App\Contracts\Repositories\PeopleRepositoryInterface;
use App\Contracts\Services\PeopleServiceInterface;

class PeopleService implements PeopleServiceInterface
{
    private PeopleRepositoryInterface $peopleRepository;

    public function __construct(PeopleRepositoryInterface $peopleRepository)
    {
        $this->peopleRepository = $peopleRepository;
    }

    public function createPerson(array $data): array
    {
        return $this->peopleRepository->create($data);
    }

    public function updatePerson(int $id, array $data): array
    {
        return $this->peopleRepository->update($id, $data);
    }

    public function findPerson(int $id): ?array
    {
        return $this->peopleRepository->findById($id);
    }

    public function deletePerson(int $id): bool
    {
        return $this->peopleRepository->delete($id);
    }
}
