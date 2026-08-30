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

        // 1. SUPER ADMIN → ALL Permissions
        $superAdmin = Role::firstOrCreate(
            ['name' => 'super-admin', 'guard_name' => 'web'],
            ['status' => true]
        );
        $superAdmin->syncPermissions(Permission::all());

        // 2. TEACHER → Manage lectures, syllabus, batches, students (except user/role management)
        $teacher = Role::firstOrCreate(
            ['name' => 'teacher', 'guard_name' => 'web'],
            ['status' => true]
        );
        $teacher->syncPermissions(Permission::whereIn('group_name', [
            'Dashboard',
            'Sidebar',
            'Lectures',
            'Syllabus',
            'Batches',
            'Students',
        ])->get());

        $student = Role::firstOrCreate(
            ['name' => 'student', 'guard_name' => 'web'],
            ['status' => true]
        );
        $student->syncPermissions([
            'view-dashboard',
            'view-lectures',
            'view-syllabus',
            'view-batches',
            'view-own-lectures',
            'view-syllabus-details',
            'edit-own-profile',
        ]);
    }
}