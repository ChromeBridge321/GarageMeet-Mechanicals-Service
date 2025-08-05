<?php

namespace App\Contracts\Repositories;

interface CitiesRepositoryInterface
{
    public function findByName( $name): array;

}
