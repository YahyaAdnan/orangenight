<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);

        $permissions = Permission::where('guard_name', 'web')->get();

        // Assign all permissions to the 'admin' role
        $adminRole->syncPermissions($permissions);

        $user = \App\Models\User::find(2);
        $user->assignRole('admin');
    }
}
