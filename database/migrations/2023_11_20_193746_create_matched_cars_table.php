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
        Schema::create('matched_cars', function (Blueprint $table) {
            $table->id();
            $table->string('car_number');
            $table->string('type');
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->string('district')->nullable();
            $table->string('location');
            $table->string('vehicle_manufacturer');
            $table->string('vehicle_model');
            $table->string('traffic_structure');
            $table->integer('source');
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
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matched_cars');
    }
};
