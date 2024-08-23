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
        Schema::create('activity_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_id')->constrained('activities')->cascadeOnDelete();
            $table->unsignedBigInteger('timestamp');
            $table->float('position_lat', 10, 6)->nullable();
            $table->float('position_long', 10, 6)->nullable();
            $table->unsignedInteger('heart_rate')->nullable();
            $table->unsignedInteger('cadence')->nullable();
            $table->float('speed')->nullable();
            $table->float('altitude_device')->nullable();
            $table->unsignedInteger('power')->nullable();
            $table->float('cumulative_distance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_points');
    }
};
