<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // Create permissions
        // Categories
        Permission::firstOrCreate(['name' => 'view categories']);
        Permission::firstOrCreate(['name' => 'create category']);
        Permission::firstOrCreate(['name' => 'edit category']);
        Permission::firstOrCreate(['name' => 'delete category']);

        // Items
        Permission::firstOrCreate(['name' => 'view items']);
        Permission::firstOrCreate(['name' => 'create item']);
        Permission::firstOrCreate(['name' => 'edit item']);
        Permission::firstOrCreate(['name' => 'delete item']);

        // Stock Transactions
        Permission::firstOrCreate(['name' => 'record stock transaction']);

        // Reports
        Permission::firstOrCreate(['name' => 'view reports']);

        // Users (for admin)
        Permission::firstOrCreate(['name' => 'manage users']);

        // Create roles and assign permissions
        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);
        $roleManager = Role::firstOrCreate(['name' => 'manager']);
        $roleStaff = Role::firstOrCreate(['name' => 'staff']);
        $roleUser = Role::firstOrCreate(['name' => 'user']);

        // Give all permissions to admin
        $roleAdmin->givePermissionTo(Permission::all());

        // Assign permissions to manager (can manage items but not categories or users)
        $roleManager->givePermissionTo([
            'view categories',
            'view items',
            'create item',
            'edit item',
            'record stock transaction',
            'view reports',
        ]);

        // Assign permissions to staff (view only + stock transaction)
        $roleStaff->givePermissionTo([
            'view categories',
            'view items', 
            'record stock transaction',
            'view reports',
        ]);

        // Assign permissions to user (view only)
        $roleUser->givePermissionTo([
            'view categories',
            'view items',
            'view reports',
        ]);

        // Assign admin role to the first user (if exists)
        $user = User::first();
        if ($user) {
            $user->assignRole('admin');
        }
    }
}
