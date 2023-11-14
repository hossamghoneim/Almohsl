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
        Schema::create('big_trackers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('car_number_id');
            $table->string('vehicle_manufacturer');
            $table->string('vehicle_model');
            $table->string('traffic_structure');
            $table->string('color');
            $table->string('model_year');
            $table->string('username');
            $table->string('board_registration_type');
            $table->string('user_identity');
            $table->string('contract_number');
            $table->string('cic');
            $table->string('certificate_status');
            $table->integer('vehicles_count');
            $table->integer('product');
            $table->integer('installments_count');
            $table->integer('late_days_count');
            $table->string('city');
            $table->string('employer');

            $table->foreign('car_number_id')->references('id')->on('car_numbers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('big_trackers');
    }
};
