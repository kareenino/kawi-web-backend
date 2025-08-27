<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bikes', function (Blueprint $table) {
            $table->id();
            // owner
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
            // identity
            $table->string('plate_number')->unique();
            $table->string('model')->nullable();
            $table->unsignedSmallInteger('year')->nullable();
            $table->date('insurance_expiry')->nullable();
            $table->date('last_serviced_at')->nullable();
            $table->unsignedInteger('odometer_km')->nullable();
            $table->string('photo_url')->nullable();
            $table->timestamps();
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bikes');
    }
};