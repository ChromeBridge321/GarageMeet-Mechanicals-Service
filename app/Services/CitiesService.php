<?php

namespace App\Services;

use App\Contracts\Repositories\CitiesRepositoryInterface;
use App\Contracts\Services\CitiesServiceInterface;


class CitiesService implements CitiesServiceInterface
{
    private $citiesRepository;

    public function __construct(CitiesRepositoryInterface $citiesRepository)
    {
        $this->citiesRepository = $citiesRepository;
    }

    public function findCityByName( $name): array
    {
        return $this->citiesRepository->findByName($name);
    }
}
