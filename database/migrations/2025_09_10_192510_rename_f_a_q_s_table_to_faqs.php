<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Rename table
        if (Schema::hasTable('f_a_q_s') && ! Schema::hasTable('faqs')) {
            Schema::rename('f_a_q_s', 'faqs');
        }
        // Ensure the expected columns exist (idempotent safety)
        Schema::table('faqs', function (Blueprint $table) {
            if (! Schema::hasColumn('faqs', 'is_published')) {
                $table->boolean('is_published')->default(false)->after('answer');
            }
        });
    }

    public function down(): void
    {
        if (Schema::hasTable('faqs') && ! Schema::hasTable('f_a_q_s')) {
            Schema::rename('faqs', 'f_a_q_s');
        }
    }
};
