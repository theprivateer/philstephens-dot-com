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
        Schema::create('heart_rate_zones', function (Blueprint $table) {
            $table->id();
            $table->date('valid_from');
            $table->unsignedInteger('zone_1_max');
            $table->unsignedInteger('zone_2_max');
            $table->unsignedInteger('zone_3_max');
            $table->unsignedInteger('zone_4_max');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('heart_rate_zones');
    }
};
