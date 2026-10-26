<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Super Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name'              => 'System Administrator',
                'phone'             => '9876543210',
                'password'          => Hash::make('Admin@123'),
                'status'            => true,
                'email_verified_at' => now(),
            ]
        );

        $admin->assignRole('super-admin');
    }
}