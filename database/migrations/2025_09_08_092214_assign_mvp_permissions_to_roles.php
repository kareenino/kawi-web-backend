<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $fullAccessRoles = ['super-admin'];

        $roles = DB::table('roles')
            ->whereIn('name', array_merge($fullAccessRoles, ['operator', 'rider']))
            ->pluck('id', 'name'); // ['roleName' => id]

        // If roles are missing, just exit gracefully
        if ($roles->isEmpty()) return;

        $allPerms   = DB::table('permissions')->where('guard_name', 'web')->pluck('id')->all();

        // Operator's allowed permission names (keep it simple, per your MVP)
        $operatorPermNames = [
            'bikes.view','bikes.create','bikes.update','bikes.delete',
            'stations.view','stations.create','stations.update','stations.delete',
            'articles.view','articles.create','articles.update',
            'operators.view',
        ];

        $operatorPermIds = DB::table('permissions')
            ->where('guard_name', 'web')
            ->whereIn('name', $operatorPermNames)
            ->pluck('id')
            ->all();

        foreach ($fullAccessRoles as $roleName) {
            if (! isset($roles[$roleName])) continue;

            $roleId = $roles[$roleName];
            foreach ($allPerms as $pid) {
                DB::table('role_has_permissions')->insertOrIgnore([
                    'permission_id' => $pid,
                    'role_id'       => $roleId,
                ]);
            }
        }

        // --- Assign: Operator (scoped in app logic; permissions are what they can do) ---
        if (isset($roles['operator'])) {
            $roleId = $roles['operator'];
            foreach ($operatorPermIds as $pid) {
                DB::table('role_has_permissions')->insertOrIgnore([
                    'permission_id' => $pid,
                    'role_id'       => $roleId,
                ]);
            }
        }

        // Rider: intentionally no panel permissions (Flutter/API only)
    }

    public function down(): void
    {
        $fullAccessRoles = ['super-admin']; // keep in sync if you changed it in up()

        $roles = DB::table('roles')
            ->whereIn('name', array_merge($fullAccessRoles, ['operator']))
            ->pluck('id', 'name');

        if ($roles->isEmpty()) return;

        $allPermIds = DB::table('permissions')->where('guard_name', 'web')->pluck('id')->all();

        $operatorPermNames = [
            'bikes.view','bikes.create','bikes.update','bikes.delete',
            'stations.view','stations.create','stations.update','stations.delete',
            'articles.view','articles.create','articles.update',
            'operators.view',
        ];
        $operatorPermIds = DB::table('permissions')
            ->where('guard_name', 'web')
            ->whereIn('name', $operatorPermNames)
            ->pluck('id')
            ->all();

        // Remove assignments for full-access roles
        foreach ($fullAccessRoles as $roleName) {
            if (! isset($roles[$roleName])) continue;

            DB::table('role_has_permissions')
                ->where('role_id', $roles[$roleName])
                ->whereIn('permission_id', $allPermIds)
                ->delete();
        }

        // Remove assignments for operator
        if (isset($roles['operator'])) {
            DB::table('role_has_permissions')
                ->where('role_id', $roles['operator'])
                ->whereIn('permission_id', $operatorPermIds)
                ->delete();
        }
    }
};