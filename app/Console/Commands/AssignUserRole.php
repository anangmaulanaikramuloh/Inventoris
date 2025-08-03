<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AssignUserRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:assign-role {email} {role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign role to user by email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $roleName = $this->argument('role');

        // Validate role exists
        if (!Role::where('name', $roleName)->exists()) {
            $this->error("Role '{$roleName}' tidak ditemukan!");
            $this->info("Role yang tersedia: admin, manager, staff, user");
            return;
        }

        // Find user by email
        $user = User::where('email', $email)->first();
        if (!$user) {
            $this->error("User dengan email '{$email}' tidak ditemukan!");
            return;
        }

        // Remove existing roles and assign new role
        $user->syncRoles([$roleName]);

        $this->info("✅ Role '{$roleName}' berhasil diberikan kepada {$user->name} ({$email})");
        
        // Show user current roles
        $this->table(
            ['Nama', 'Email', 'Role'],
            [[$user->name, $user->email, $user->getRoleNames()->implode(', ')]]
        );
    }
}
