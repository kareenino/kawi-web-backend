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
        Schema::table('f_a_q_s', function (Blueprint $table) {
            $table->dropColumn('rating');
            $table->boolean('is_published')->default(false)->after('answer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('f_a_q_s', function (Blueprint $table) {
            $table->integer('rating');
            $table->dropColumn('is_published')->default(false)->after('answer');
        });
    }
};
