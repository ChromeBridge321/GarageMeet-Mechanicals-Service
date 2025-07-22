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
        Schema::create('employees', function (Blueprint $table) {
            $table->id('employees_id');
            $table->unsignedBigInteger('mechanical_workshops_id');
            $table->unsignedBigInteger('peoples_id');
            $table->foreign('mechanical_workshops_id')->references('id')->on('mechanical_workshops')->onDelete('cascade');
            $table->foreign('peoples_id')->references('peoples_id')->on('peoples')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
