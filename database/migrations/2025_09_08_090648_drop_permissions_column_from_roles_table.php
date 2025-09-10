<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasColumn('roles', 'permissions')) {
            Schema::table('roles', function (Blueprint $table) {
                $table->dropColumn('permissions');
            });
        }
    }

    public function down(): void
    {
        // Recreate the column if you ever rollback (adjust type if yours was different)
        Schema::table('roles', function (Blueprint $table) {
            $table->json('permissions')->nullable();
        });
    }
};