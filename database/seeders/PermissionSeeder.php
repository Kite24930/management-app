<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Permission作成
        $accessToAdmin = Permission::create(['name' => 'access to admin']);
        $accessToManager = Permission::create(['name' => 'access to manager']);
        $accessToEmployee = Permission::create(['name' => 'access to employee']);

        // Role作成
        $admin = Role::create(['name' => 'admin']);
        $manager = Role::create(['name' => 'manager']);
        $employee = Role::create(['name' => 'employee']);

        // RoleにPermissionを付与
        $admin->givePermissionTo($accessToAdmin);
        $manager->givePermissionTo($accessToManager);
        $employee->givePermissionTo($accessToEmployee);
    }
}
