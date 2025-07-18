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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id('vehicles_id');
            $table->string('plates', 15);
            $table->unsignedBigInteger('makes_model_id');
            $table->unsignedBigInteger('clients_id');
            $table->foreign('clients_id')->references('clients_id')->on('clients')->onDelete('cascade');
            $table->foreign('makes_model_id')->references('makes_model_id')->on('makes_model')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
