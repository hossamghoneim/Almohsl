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
            $table->string('type')->nullable();
            $table->string('district');
            $table->string('location');
            $table->string('url');
            $table->string('vehicle_manufacturer')->nullable();
            $table->string('vehicle_model')->nullable();
            $table->string('traffic_structure')->nullable();
            $table->integer('source');
            $table->string('color')->nullable();
            $table->string('model_year')->nullable();
            $table->string('username')->nullable();
            $table->string('board_registration_type')->nullable();
            $table->string('user_identity')->nullable();
            $table->string('contract_number')->nullable();
            $table->string('cic')->nullable();
            $table->string('certificate_status')->nullable();
            $table->integer('vehicles_count')->nullable();
            $table->integer('product')->nullable();
            $table->integer('installments_count')->nullable();
            $table->integer('late_days_count')->nullable();
            $table->string('city')->nullable();
            $table->string('employer')->nullable();
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
