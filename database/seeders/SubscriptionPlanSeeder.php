<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'GarageMeet Base',
                'description' => 'Suscripción Base a la plataforma de administración de GarageMeet',
                'stripe_price_id' => 'price_1RrRnVPlCUIY9G9QYajsxWl8', // Reemplazar con tu ID real de Stripe
                'stripe_product_id' => 'prod_Sn1rUsuXz8QSXN', // Reemplazar con tu ID real de Stripe
                'price' => 540,
                'currency' => 'mxn',
                'interval' => 'month',
                'interval_count' => 1,
                'features' => [
                    'Seguimientos de cita',
                    'Reportes de ventas del día',
                    'Reportes de utilidad',
                    'Reparaciones más solicitadas',
                    'Acceso al panel de administracion'
                ],
                'is_active' => true,
                'is_popular' => false
            ],
            [
                'name' => 'GarageMeet Plus',
                'description' => 'Suscripción premium a los servicios de GarageMeet',
                'stripe_price_id' => 'price_1RrRqDPlCUIY9G9QG4sc8nwC', // Reemplazar con tu ID real de Stripe
                'stripe_product_id' => 'prod_Sn1u9BRr1pF56q', // Reemplazar con tu ID real de Stripe
                'price' => 740,
                'currency' => 'mxn',
                'interval' => 'month',
                'interval_count' => 1,
                'features' => [
                    'Todos los beneficios del plan base',
                    'Página web propia',
                    'Citas en línea',
                ],
                'is_active' => true,
                'is_popular' => false
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::create($plan);
        }
    }
}
