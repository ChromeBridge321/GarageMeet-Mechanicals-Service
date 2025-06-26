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
        Schema::create('mechanical_workshops', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('users_id');
            $table->integer('cities_id');
            $table->string('name',60);
            $table->string('cellphone_number',10);
            $table->string('email',120);
            $table->text('address');
            $table->text('google_maps_link');
            $table->foreign('users_id')->references('users_id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mechanical_workshops');
    }
};
