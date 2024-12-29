<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AccountingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $accountingRole = Role::firstOrCreate(['name' => 'Accounting', 'guard_name' => 'web']);

        // Define the permissions related to Transaction, Expense, Payment, and Receipt
        $permissions = [
            'view Transaction',
            'view-any Transaction',
            'create Transaction',
            'update Transaction',
            'delete Transaction',
            'force-delete Transaction',
            'view Expense',
            'view-any Expense',
            'create Expense',
            'update Expense',
            'delete Expense',
            'force-delete Expense',
            'view Payment',
            'view-any Payment',
            'create Payment',
            'update Payment',
            'delete Payment',
            'force-delete Payment',
            'view Receipt',
            'view-any Receipt',
            'create Receipt',
            'update Receipt',
            'delete Receipt',
            'force-delete Receipt',
        ];

        // Find and assign permissions to the Accounting role
        foreach ($permissions as $permissionName) {
            $permission = Permission::where('name', $permissionName)
                ->where('guard_name', 'web')->first();

            if ($permission) {
                $accountingRole->givePermissionTo($permission);
            } else {
                $this->command->warn("Permission '{$permissionName}' does not exist.");
            }
        }

        $this->command->info('Permissions successfully assigned to the Accounting role.');
    }
}
