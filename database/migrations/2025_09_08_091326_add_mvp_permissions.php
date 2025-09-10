<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $now = now();

        // Your resources (deduped)
        $resources = [
            'bikes',
            'stations',
            'operators',
            'articles',
            'categories',
            'f_a_q_s',
            'ecopoints',
            'favorites',
            'payments',
            'reviews',
            'swap_histories',
            'users',
        ];

        // Minimal CRUD actions
        $actions = ['view','create','update','delete'];

        // Build the target permission names
        $rows = [];
        foreach ($resources as $res) {
            foreach ($actions as $act) {
                $rows[] = [
                    'name'       => "{$res}.{$act}",
                    'guard_name' => 'web',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        // Optional extra: only superadmin should later receive this
        $rows[] = [
            'name'       => 'articles.publish',
            'guard_name' => 'web',
            'created_at' => $now,
            'updated_at' => $now,
        ];

        // Idempotent insert (no duplicates if re-run)
        foreach ($rows as $perm) {
            $exists = DB::table('permissions')
                ->where('name', $perm['name'])
                ->where('guard_name', $perm['guard_name'])
                ->exists();

            if (! $exists) {
                DB::table('permissions')->insert($perm);
            }
        }
    }

    public function down(): void
    {
        $resources = [
            'bikes',
            'stations',
            'operators',
            'articles',
            'categories',
            'f_a_q_s',
            'ecopoints',
            'favorites',
            'payments',
            'reviews',
            'swap_histories',
            'users',
        ];
        $actions = ['view','create','update','delete'];

        $names = [];
        foreach ($resources as $res) {
            foreach ($actions as $act) {
                $names[] = "{$res}.{$act}";
            }
        }
        $names[] = 'articles.publish';

        DB::table('permissions')
            ->whereIn('name', $names)
            ->where('guard_name', 'web')
            ->delete();
    }
};