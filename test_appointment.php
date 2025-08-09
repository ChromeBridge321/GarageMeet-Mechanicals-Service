<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Services\AppointmentService;
use App\Repositories\AppointmentRepository;
use App\Models\Appointments;
use App\Models\Mechanicals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

// Configurar Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "=== Iniciando prueba de creación de cita ===\n";

    // Verificar talleres disponibles
    echo "=== Talleres disponibles ===\n";
    $workshops = Mechanicals::all();
    if ($workshops->count() > 0) {
        foreach ($workshops as $workshop) {
            echo $workshop->id . ' - ' . $workshop->name . ' (' . $workshop->email . ')' . "\n";
        }
        $selectedWorkshopId = $workshops->first()->id;
    } else {
        echo "No hay talleres disponibles. Usando ID 1 por defecto...\n";
        $selectedWorkshopId = 1;
    }

    // Datos de prueba
    $data = [
        'client_name' => 'Juan Perez',
        'client_email' => 'test@example.com',
        'client_phone' => '555-1234',
        'vehicle_model' => 'Toyota Corolla',
        'vehicle_year' => 2020,
        'description' => 'Cambio de aceite - Toyota Corolla 2020',
        'preferred_date' => '2024-01-15',
        'preferred_time' => '10:00',
        'mechanical_workshops_id' => $selectedWorkshopId
    ];

    echo "Datos de la cita:\n";
    print_r($data);

    // Crear instancia del servicio
    $appointmentRepository = new AppointmentRepository();
    $appointmentService = new AppointmentService($appointmentRepository);

    echo "\n=== Creando cita ===\n";
    $result = $appointmentService->createAppointmentRequest($data);

    echo "Resultado:\n";
    print_r($result);

    echo "\n=== Verificando logs ===\n";
    echo "Revisa el archivo storage/logs/laravel.log para ver todos los logs de debugging.\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
