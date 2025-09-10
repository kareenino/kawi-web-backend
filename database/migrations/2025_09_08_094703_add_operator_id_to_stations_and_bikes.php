<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('stations') && !Schema::hasColumn('stations','operator_id')) {
            Schema::table('stations', function (Blueprint $table) {
                $table->unsignedBigInteger('operator_id')->nullable()->after('id');
                $table->foreign('operator_id')->references('id')->on('operators')->nullOnDelete();
                $table->index('operator_id');
            });
        }

        if (Schema::hasTable('bikes') && !Schema::hasColumn('bikes','operator_id')) {
            Schema::table('bikes', function (Blueprint $table) {
                $table->unsignedBigInteger('operator_id')->nullable()->after('id');
                $table->foreign('operator_id')->references('id')->on('operators')->nullOnDelete();
                $table->index('operator_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('stations') && Schema::hasColumn('stations','operator_id')) {
            Schema::table('stations', function (Blueprint $table) {
                $table->dropForeign(['operator_id']);
                $table->dropIndex(['operator_id']);
                $table->dropColumn('operator_id');
            });
        }

        if (Schema::hasTable('bikes') && Schema::hasColumn('bikes','operator_id')) {
            Schema::table('bikes', function (Blueprint $table) {
                $table->dropForeign(['operator_id']);
                $table->dropIndex(['operator_id']);
                $table->dropColumn('operator_id');
            });
        }
    }
};