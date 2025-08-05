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
        Schema::create('cities', function (Blueprint $table) {
            $table->unsignedBigInteger('cities_id');
            $table->string('name', 60);
            $table->unsignedBigInteger('states_id');
            $table->primary(['cities_id', 'states_id']);
            //$table->foreign('states_id')->references('states_id')->on('states')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
