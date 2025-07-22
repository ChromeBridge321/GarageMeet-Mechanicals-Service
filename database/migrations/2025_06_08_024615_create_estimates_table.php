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
        Schema::create('estimates', function (Blueprint $table) {
            $table->id('estimates_id');
            $table->unsignedBigInteger('services_id');
            $table->unsignedBigInteger('clients_id');
            $table->unsignedBigInteger('mechanical_workshops_id');
            $table->dateTime('date');
            $table->foreign('services_id')->references('services_id')->on('services')->onDelete('cascade');
            $table->foreign('clients_id')->references('clients_id')->on('clients')->onDelete('cascade');
            $table->foreign('mechanical_workshops_id')->references('id')->on('mechanical_workshops')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estimates');
    }
};
