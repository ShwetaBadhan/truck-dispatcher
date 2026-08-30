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

            // Sidebar
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
            ['name' => 'view-own-lectures', 'group_name' => 'Lectures'], // Student ke liye

            // Syllabus
            ['name' => 'create-syllabus', 'group_name' => 'Syllabus'],
            ['name' => 'edit-syllabus', 'group_name' => 'Syllabus'],
            ['name' => 'delete-syllabus', 'group_name' => 'Syllabus'],
            ['name' => 'view-syllabus-details', 'group_name' => 'Syllabus'],

            // Batches
            ['name' => 'create-batches', 'group_name' => 'Batches'],
            ['name' => 'edit-batches', 'group_name' => 'Batches'],
            ['name' => 'delete-batches', 'group_name' => 'Batches'],
            ['name' => 'assign-batch', 'group_name' => 'Batches'],

            // Students
            ['name' => 'create-students', 'group_name' => 'Students'],
            ['name' => 'edit-students', 'group_name' => 'Students'],
            ['name' => 'delete-students', 'group_name' => 'Students'],
            ['name' => 'edit-own-profile', 'group_name' => 'Students'], 
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