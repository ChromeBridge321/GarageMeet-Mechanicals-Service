<?php

namespace App\Contracts\Services;
interface CitiesServiceInterface
{
    public function findCityByName( $name): array;
}

