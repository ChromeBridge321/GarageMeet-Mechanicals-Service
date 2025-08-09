<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Eliminar la tabla existente
        Schema::dropIfExists('appointments');

        // Crear la nueva tabla con estructura completa para el sistema de citas
        Schema::create('appointments', function (Blueprint $table) {
            $table->id('appointment_id');
            $table->unsignedBigInteger('mechanical_workshops_id');
            $table->string('client_name', 255);
            $table->string('client_email', 255);
            $table->string('client_phone', 20);
            $table->text('description'); // Descripción del problema
            $table->datetime('appointment_date')->nullable(); // Fecha asignada por el taller
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
            $table->enum('created_by', ['app', 'dashboard'])->default('app');
            $table->string('cancellation_token', 64)->unique(); // Token para cancelación pública
            $table->text('notes')->nullable(); // Notas internas del taller
            $table->timestamps();

            // Foreign keys
            $table->foreign('mechanical_workshops_id')->references('id')->on('mechanical_workshops')->onDelete('cascade');

            // Índices para optimización
            $table->index(['mechanical_workshops_id', 'status']);
            $table->index(['appointment_date']);
            $table->index(['client_email']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');

        // Recrear la tabla original si es necesario (opcional)
        Schema::create('appointments', function (Blueprint $table) {
            $table->id('appointments_id');
            $table->unsignedBigInteger('services_id');
            $table->unsignedBigInteger('clients_id');
            $table->unsignedBigInteger('mechanical_workshops_id');
            $table->dateTime('date');
            $table->foreign('mechanical_workshops_id')->references('id')->on('mechanical_workshops')->onDelete('cascade');
            $table->foreign('services_id')->references('services_id')->on('services')->onDelete('cascade');
            $table->foreign('clients_id')->references('clients_id')->on('clients')->onDelete('cascade');
        });
    }
};
