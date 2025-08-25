<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            // Orchid uses slug + permissions (json)
            if (!Schema::hasColumn('roles', 'slug')) {
                $table->string('slug')->nullable()->after('id');
            }
            if (!Schema::hasColumn('roles', 'permissions')) {
                // Use JSON if available; fallback to TEXT if your MySQL < 5.7
                $table->json('permissions')->nullable()->after('name');
                // If your DB doesn't support JSON, use:
                // $table->text('permissions')->nullable()->after('name');
            }
        });

        // Optional: backfill slug from name for existing rows
        DB::table('roles')
            ->whereNull('slug')
            ->update(['slug' => DB::raw("LOWER(REPLACE(name,' ','_'))")]);
    }

    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            if (Schema::hasColumn('roles', 'permissions')) {
                $table->dropColumn('permissions');
            }
            if (Schema::hasColumn('roles', 'slug')) {
                $table->dropColumn('slug');
            }
        });
    }
};