<?php

namespace App\Providers;

use App\Contracts\Repositories\CitiesRepositoryInterface;
use App\Contracts\Repositories\ClientRepositoryInterface;
use App\Contracts\Repositories\EmployeeRepositoryInterface;
use App\Contracts\Repositories\MechanicalWorkshopRepositoryInterface;
use App\Contracts\Repositories\PaymentTypesRepositoryInterface;
use App\Contracts\Repositories\PeopleRepositoryInterface;
use App\Contracts\Repositories\PiecesRepositoryInterface;
use App\Contracts\Repositories\PositionRepositoryInterface;
use App\Contracts\Repositories\SalesRepositoryInterface;
use App\Contracts\Repositories\ServicesRepositoryInterface;
use App\Contracts\Repositories\VehiclesClientsRepositoryInterface;
use App\Contracts\Repositories\VehiclesRepositoryInterface;
use App\Contracts\Services\CitiesServiceInterface;
use App\Contracts\Services\ClientServiceInterface;
use App\Contracts\Services\EmployeeServiceInterface;
use App\Contracts\Services\MechanicalWorkshopServiceInterface;
use App\Contracts\Services\PaymentTypesServiceInterface;
use App\Contracts\Services\PeopleServiceInterface;
use App\Contracts\Services\PiecesServiceInterface;
use App\Contracts\Services\PositionServiceInterface;
use App\Contracts\Services\SalesServiceInterface;
use App\Contracts\Services\ServicesServiceInterface;
use App\Contracts\Services\VehiclesServiceInterface;
use App\Repositories\CitiesRepository;
use App\Repositories\ClientRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\MechanicalWorkshopRepository;
use App\Repositories\PaymentTypesRepository;
use App\Repositories\PeopleRepository;
use App\Repositories\PiecesRepository;
use App\Repositories\PositionRepository;
use App\Repositories\SalesRepository;
use App\Repositories\ServicesRepository;
use App\Repositories\VehiclesClientsRepository;
use App\Repositories\VehiclesRepository;
use App\Services\CitiesService;
use App\Services\ClientService;
use App\Services\EmployeeService;
use App\Services\MechanicalWorkshopService;
use App\Services\PaymentTypesService;
use App\Services\PeopleService;
use App\Services\PiecesService;
use App\Services\PositionService;
use App\Services\SalesService;
use App\Services\ServicesService;
use App\Services\VehiclesService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Repository bindings
        $this->app->bind(PeopleRepositoryInterface::class, PeopleRepository::class);
        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);
        $this->app->bind(EmployeeRepositoryInterface::class, EmployeeRepository::class);
        $this->app->bind(VehiclesClientsRepositoryInterface::class, VehiclesClientsRepository::class);
        $this->app->bind(PositionRepositoryInterface::class, PositionRepository::class);
        $this->app->bind(MechanicalWorkshopRepositoryInterface::class, MechanicalWorkshopRepository::class);
        $this->app->bind(VehiclesRepositoryInterface::class, VehiclesRepository::class);
        $this->app->bind(CitiesRepositoryInterface::class, CitiesRepository::class);
        $this->app->bind(ServicesRepositoryInterface::class, ServicesRepository::class);
        $this->app->bind(PaymentTypesRepositoryInterface::class, PaymentTypesRepository::class);
        $this->app->bind(PiecesRepositoryInterface::class, PiecesRepository::class);
        $this->app->bind(SalesRepositoryInterface::class, SalesRepository::class);

        // Service bindings
        $this->app->bind(PeopleServiceInterface::class, PeopleService::class);
        $this->app->bind(ClientServiceInterface::class, ClientService::class);
        $this->app->bind(EmployeeServiceInterface::class, EmployeeService::class);
        $this->app->bind(PositionServiceInterface::class, PositionService::class);
        $this->app->bind(MechanicalWorkshopServiceInterface::class, MechanicalWorkshopService::class);
        $this->app->bind(VehiclesServiceInterface::class, VehiclesService::class);
        $this->app->bind(CitiesServiceInterface::class, CitiesService::class);
        $this->app->bind(ServicesServiceInterface::class, ServicesService::class);
        $this->app->bind(PaymentTypesServiceInterface::class, PaymentTypesService::class);
        $this->app->bind(PiecesServiceInterface::class, PiecesService::class);
        $this->app->bind(SalesServiceInterface::class, SalesService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
