<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DefaultUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@inventaris.com'],
            [
                'name' => 'Admin Inventaris',
                'password' => Hash::make('admin123'),
            ]
        );
        
        if (!$adminUser->hasRole('admin')) {
            $adminUser->assignRole('admin');
            $this->command->info('✅ User admin@inventaris.com created with admin role');
        }

        // Create Staff User
        $staffUser = User::firstOrCreate(
            ['email' => 'staff@inventaris.com'],
            [
                'name' => 'Staff Inventaris',
                'password' => Hash::make('staff123'),
            ]
        );
        
        if (!$staffUser->hasRole('staff')) {
            $staffUser->assignRole('staff');
            $this->command->info('✅ User staff@inventaris.com created with staff role');
        }

        // Create Manager User
        $managerUser = User::firstOrCreate(
            ['email' => 'manager@inventaris.com'],
            [
                'name' => 'Manager Inventaris',
                'password' => Hash::make('manager123'),
            ]
        );
        
        if (!$managerUser->hasRole('manager')) {
            $managerUser->assignRole('manager');
            $this->command->info('✅ User manager@inventaris.com created with manager role');
        }

        // Create Regular User
        $regularUser = User::firstOrCreate(
            ['email' => 'user@inventaris.com'],
            [
                'name' => 'User Inventaris',
                'password' => Hash::make('user123'),
            ]
        );
        
        if (!$regularUser->hasRole('user')) {
            $regularUser->assignRole('user');
            $this->command->info('✅ User user@inventaris.com created with user role');
        }

        $this->command->info('🎉 Default users setup completed!');
        $this->command->line('');
        $this->command->table(
            ['Email', 'Password', 'Role'],
            [
                ['admin@inventaris.com', 'admin123', 'Admin'],
                ['manager@inventaris.com', 'manager123', 'Manager'],
                ['staff@inventaris.com', 'staff123', 'Staff'],
                ['user@inventaris.com', 'user123', 'User'],
            ]
        );
    }
}
