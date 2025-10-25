<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chambers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('address');
            $table->string('phone')->nullable(); // Changed from decimal to string
            $table->decimal('fee', 8, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('working_days');
            $table->time('start_time')->default('09:00');
            $table->time('end_time')->default('17:00');
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
