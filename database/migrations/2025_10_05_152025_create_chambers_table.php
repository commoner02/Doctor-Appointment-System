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
        Schema::create('chambers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->string('chamber_name', 100);
            $table->string('chamber_location', 255)->nullable();
            $table->string('phone', 20)->nullable();
            $table->time('start_time');
            $table->time('end_time');
            $table->set('working_days', ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chambers');
    }
};
