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
        Schema::create('estimates_pieces', function (Blueprint $table) {
            $table->unsignedBigInteger('estimates_id');
            $table->unsignedBigInteger('pieces_id');
            $table->foreign('estimates_id')->references('estimates_id')->on('estimates')->onDelete('cascade');
            $table->foreign('pieces_id')->references('pieces_id')->on('pieces')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estimates_pieces');
    }
};
