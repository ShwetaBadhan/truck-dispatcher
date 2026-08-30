<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Dashboard
            ['name' => 'view-dashboard', 'group_name' => 'Dashboard'],
            ['name' => 'view-shipments-stats', 'group_name' => 'Dashboard'],
            ['name' => 'view-patient-stats', 'group_name' => 'Dashboard'],
            ['name' => 'view-appointment-stats', 'group_name' => 'Dashboard'],
            ['name' => 'view-revenue-stats', 'group_name' => 'Dashboard'],

            // sidebar
            ['name' => 'view-driver', 'group_name' => 'Sidebar'],
            ['name' => 'view-companies', 'group_name' => 'Sidebar'],
            ['name' => 'view-trailers', 'group_name' => 'Sidebar'],
            ['name' => 'view-trucks', 'group_name' => 'Sidebar'],
            ['name' => 'view-dispatch', 'group_name' => 'Sidebar'],
            ['name' => 'view-syllabus', 'group_name' => 'Sidebar'],
            ['name' => 'view-lectures', 'group_name' => 'Sidebar'],
            ['name' => 'view-students', 'group_name' => 'Sidebar'],
            ['name' => 'view-batches', 'group_name' => 'Sidebar'],
            ['name' => 'view-action', 'group_name' => 'Sidebar'],
           
            // Lectures           
            ['name' => 'create-lectures', 'group_name' => 'Lectures'],
            ['name' => 'edit-lectures', 'group_name' => 'Lectures'],
            ['name' => 'delete-lectures', 'group_name' => 'Lectures'],

            // Syllabus           
            ['name' => 'create-syllabus', 'group_name' => 'Syllabus'],
            ['name' => 'edit-syllabus', 'group_name' => 'Syllabus'],
            ['name' => 'delete-syllabus', 'group_name' => 'Syllabus'],



            // Users
            ['name' => 'view-users', 'group_name' => 'Users'],
            ['name' => 'create-users', 'group_name' => 'Users'],
            ['name' => 'edit-users', 'group_name' => 'Users'],
            ['name' => 'delete-users', 'group_name' => 'Users'],
            
            // Roles & Permissions
            ['name' => 'view-roles', 'group_name' => 'Roles'],
            ['name' => 'create-roles', 'group_name' => 'Roles'],
            ['name' => 'edit-roles', 'group_name' => 'Roles'],
            ['name' => 'delete-roles', 'group_name' => 'Roles'],
            ['name' => 'assign-permissions', 'group_name' => 'Roles'],
            
           ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(
                ['name' => $perm['name'], 'guard_name' => 'web'],
                ['group_name' => $perm['group_name'], 'status' => true]
            );
        }
    }
}