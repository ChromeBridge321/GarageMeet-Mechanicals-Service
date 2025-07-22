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
        Schema::create('makes_model', function (Blueprint $table) {
            $table->id('makes_model_id');
            $table->unsignedBigInteger('make_id');
            $table->unsignedBigInteger('model_id');
            $table->foreign('make_id')->references('make_id')->on('makes')->onDelete('cascade');
            $table->foreign('model_id')->references('model_id')->on('models')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('makes_model');
    }
};
