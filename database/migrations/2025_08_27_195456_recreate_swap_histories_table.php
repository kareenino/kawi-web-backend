<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('swap_histories');

        Schema::create('swap_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('station_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('bike_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('operator_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->unsignedTinyInteger('battery_count')->default(1);
            $table->decimal('price', 8, 2)->nullable();
            $table->enum('status', ['completed','failed','cancelled'])->default('completed');
            $table->text('notes')->nullable();
            $table->timestamp('swapped_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('swap_histories');
    }
};