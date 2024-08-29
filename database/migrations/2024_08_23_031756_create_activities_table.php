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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('timezone')->nullable();
            $table->text('file')->nullable();
            $table->string('sport')->nullable();
            $table->string('subsport')->nullable();
            $table->boolean('stationary')->nullable();
            $table->string('title')->nullable();
            $table->longText('content')->nullable();
            $table->dateTime('started_at')->nullable();
            $table->unsignedInteger('total_elapsed_time')->nullable();
            $table->unsignedInteger('total_timer_time')->nullable();
            $table->float('avg_speed')->nullable();
            $table->float('max_speed')->nullable();
            $table->float('total_distance')->nullable();
            $table->unsignedInteger('avg_cadence')->nullable();
            $table->unsignedInteger('max_cadence')->nullable();
            $table->unsignedInteger('avg_power')->nullable();
            $table->unsignedInteger('max_power')->nullable();
            $table->unsignedInteger('avg_heart_rate')->nullable();
            $table->unsignedInteger('max_heart_rate')->nullable();
            $table->unsignedInteger('total_calories')->nullable();
            $table->unsignedInteger('total_ascent_device')->nullable();
            $table->text('polyline')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
