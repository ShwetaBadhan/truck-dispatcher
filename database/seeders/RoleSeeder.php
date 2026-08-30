<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Super Admin → ALL Permissions
        $superAdmin = Role::firstOrCreate(
            ['name' => 'super-admin', 'guard_name' => 'web'],
            ['status' => true]
        );
        $superAdmin->syncPermissions(Permission::all());

        // 2. Admin → All clinic permissions (except user/role management)
        $admin = Role::firstOrCreate(
            ['name' => 'admin', 'guard_name' => 'web'],
            ['status' => true]
        );
        $admin->syncPermissions(
            Permission::whereNotIn('group_name', ['Users', 'Roles'])->get()
        );

       
    }
}