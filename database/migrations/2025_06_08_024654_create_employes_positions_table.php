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
        Schema::create('employes_positions', function (Blueprint $table) {
           $table->unsignedBigInteger('positions_id');
           $table->unsignedBigInteger('employees_id');
           $table->foreign('positions_id')->references('positions_id')->on('positions')->onDelete('cascade');
           $table->foreign('employees_id')->references('employees_id')->on('employees')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employes_positions');
    }
};
