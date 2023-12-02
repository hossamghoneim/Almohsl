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
        Schema::create('mini_trackers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('car_number_id');
            $table->string('type')->nullable();
            $table->string('location');
            $table->string('district');
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->string('url');
            $table->date('date');

            $table->foreign('car_number_id')->references('id')->on('car_numbers')->onDelete('cascade');
            $table->unique(['car_number_id', 'url', 'date']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mini_trackers');
    }
};
