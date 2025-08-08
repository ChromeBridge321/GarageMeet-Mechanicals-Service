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
        Schema::create('services_by_sales', function (Blueprint $table) {
            $table->unsignedBigInteger('services_id');
            $table->unsignedBigInteger('services_sales_id');
            $table->foreign('services_id')->references('services_id')->on('services')->onDelete('cascade');
            $table->foreign('services_sales_id')->references('services_sales_id')->on('services_sales')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services_by_sales');
    }
};
