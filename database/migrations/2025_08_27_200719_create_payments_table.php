<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('swap_history_id')
                  ->nullable()
                  ->constrained('swap_histories')
                  ->nullOnDelete();

            $table->enum('method', ['mpesa', 'cash']);
            $table->decimal('amount', 10, 2);
            $table->string('reference')->nullable();
            $table->enum('status', ['pending','succeeded','failed'])
                  ->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};