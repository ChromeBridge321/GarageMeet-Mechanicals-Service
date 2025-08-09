<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Stripe\Stripe;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind appointment interfaces
        $this->app->bind(
            \App\Contracts\Repositories\AppointmentRepositoryInterface::class,
            \App\Repositories\AppointmentRepository::class
        );

        $this->app->bind(
            \App\Contracts\Services\AppointmentServiceInterface::class,
            \App\Services\AppointmentService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         Stripe::setApiKey(config('services.stripe.secret'));
    }
}
