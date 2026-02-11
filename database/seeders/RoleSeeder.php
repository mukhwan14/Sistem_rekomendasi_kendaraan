<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create roles
        $roleAdmin = \Spatie\Permission\Models\Role::create(['name' => 'admin']);
        $roleUser = \Spatie\Permission\Models\Role::create(['name' => 'user']);

        // create demo admin
        $user = \App\Models\User::factory()->create([
            'name' => 'Admin System',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole($roleAdmin);

        // create demo user
        $user2 = \App\Models\User::factory()->create([
            'name' => 'User Demo',
            'email' => 'user@gmail.com',
            'password' => bcrypt('password'),
        ]);
        $user2->assignRole($roleUser);
    }
}
