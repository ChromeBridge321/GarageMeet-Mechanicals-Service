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
        Schema::create('payment_types', function (Blueprint $table) {
            $table->id('payment_types_id');
            $table->string('name', 60);
            $table->unsignedBigInteger('mechanical_workshops_id');
            $table->timestamps();
            $table->foreign('mechanical_workshops_id')->references('id')->on('mechanical_workshops')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_types');
    }
};
