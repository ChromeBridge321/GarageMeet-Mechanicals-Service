<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use App\Models\type_user;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    private $password = '$2y$12$ZItzY/K7Xj4IGchtQUBF2.GMGzovNOh7pWHYAbB.o.LS2qbdcz4E2';
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $TypeUser = [
            [
                'name' => 'Admin',
            ],
            [
                'name' => 'User',
            ],
        ];

        foreach ($TypeUser as $type) {
            type_user::create($type);
        }

        $user = [
            'users_id' => 1,
            'name' => 'David',
            'last_name' => 'Garcia Jeronimo',
            'email' => 'correo@ejemplo.com',
            'email_verified_at' => null,
            'password' => $this->password,
            'type_users_id' => 1,
            'remember_token' => null,
            'stripe_id' => 'cus_SoAQhi7HLc4haJ',
            'pm_type' => null,
            'pm_last_four' => null,
            'trial_ends_at' => null
        ];

        foreach ($user as $key => $value) {
            if (User::where('email', $user['email'])->doesntExist()) {
                User::create($user);
            }
        }

        $plans = [
            [
                'name' => 'GarageMeet Plus',
                'description' => 'Suscripción total a los servicios de GarageMeet',
                'stripe_price_id' => 'price_1RrrYiPlCUIY9G9QGDrgUHFF', // Reemplazar con tu ID real de Stripe
                'stripe_product_id' => 'prod_SnSTxIeoW0Byp7', // Reemplazar con tu ID real de Stripe
                'price' => 250,
                'currency' => 'mxn',
                'interval' => 'month',
                'interval_count' => 1,
                'features' => [
                    'Citas en línea',
                    'Sección web propia',
                    'Citas en línea',
                    'Rendimiento del taller',
                    'Reportes de ventas del día',
                    'Reportes de utilidad',
                    'Registro de clientes',
                    'Registro de empleados',
                    'Registro de servicios',
                    'Registro de citas',
                ],
                'is_active' => true,
                'is_popular' => true
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::create($plan);
        }
    }
}
