<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSecondBatch extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = array();

        $permissions[] = Permission::create([
            'name' => 'cancel Delivery',
            'guard_name' => 'web',
        ]);

        $permissions[] = Permission::create([
            'name' => 'distribution',
            'guard_name' => 'web',
        ]);

        $permissions[] = Permission::create([
            'name' => 'import',
            'guard_name' => 'web',
        ]);

        $permissions[] = Permission::create([
            'name' => 'refund',
            'guard_name' => 'web',
        ]);

        $permissions[] = Permission::create([
            'name' => 'view Role',
            'guard_name' => 'web',
        ]);

        $permissions[] = Permission::create([
            'name' => 'view-any Role',
            'guard_name' => 'web',
        ]);

        $permissions[] = Permission::create([
            'name' => 'create Role',
            'guard_name' => 'web',
        ]);

        $permissions[] = Permission::create([
            'name' => 'updaten Role',
            'guard_name' => 'web',
        ]);

        $permissions[] = Permission::create([
            'name' => 'delete Role',
            'guard_name' => 'web',
        ]);

        $permissions[] = Permission::create([
            'name' => 'force-delete Role',
            'guard_name' => 'web',
        ]);

        $adminRole = Role::find(1);
        $adminRole->givePermissionTo($permissions);
    }
}
