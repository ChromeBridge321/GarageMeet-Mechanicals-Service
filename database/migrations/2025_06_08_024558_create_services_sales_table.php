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
        Schema::create('services_sales', function (Blueprint $table) {
            $table->id('services_sales_id');
            $table->unsignedBigInteger('payment_types_id');
            $table->unsignedBigInteger('employees_id');
            $table->unsignedBigInteger('clients_id');
            $table->unsignedBigInteger('pieces_id');
            $table->unsignedBigInteger('mechanical_workshops_id');
            $table->dateTime('date');
            $table->double('price', 8, 2);
            $table->foreign('payment_types_id')->references('payment_types_id')->on('payment_types')->onDelete('cascade');
            $table->foreign('employees_id')->references('employees_id')->on('employees')->onDelete('cascade');
            $table->foreign('clients_id')->references('clients_id')->on('clients')->onDelete('cascade');
            $table->foreign('pieces_id')->references('pieces_id')->on('pieces')->onDelete('cascade');
            $table->foreign('mechanical_workshops_id')->references('id')->on('mechanical_workshops')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services_sales');
    }
};
