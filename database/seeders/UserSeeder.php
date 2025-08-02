<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure roles exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $operatorRole = Role::firstOrCreate(['name' => 'operator']);
        $riderRole = Role::firstOrCreate(['name' => 'rider']);

        // Create Admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@kawigo.com',
            'password' => Hash::make('password123'),
        ]);
        $admin->assignRole($adminRole);

        // Create Operator
        $operator = User::create([
            'name' => 'Operator One',
            'email' => 'operator@kawigo.com',
            'password' => Hash::make('password123'),
        ]);
        $operator->assignRole($operatorRole);

        // Create 10 Rider Users
        User::factory(10)->create()->each(function ($user) use ($riderRole) {
            $user->assignRole($riderRole);
        });
    }
}