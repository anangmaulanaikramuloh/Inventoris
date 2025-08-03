<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class ListUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all users with their roles';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->info('Tidak ada user ditemukan.');
            return;
        }

        $userData = [];
        foreach ($users as $user) {
            $roles = $user->getRoleNames()->isEmpty() 
                ? 'Tidak ada role' 
                : $user->getRoleNames()->implode(', ');
                
            $userData[] = [
                $user->id,
                $user->name,
                $user->email,
                $roles,
                $user->created_at->format('d/m/Y')
            ];
        }

        $this->table(
            ['ID', 'Nama', 'Email', 'Role', 'Terdaftar'],
            $userData
        );

        $this->info("\n📝 Untuk memberikan role, gunakan command:");
        $this->line("php artisan user:assign-role [email] [role]");
        $this->line("Role tersedia: admin, manager, staff, user");
        $this->line("Contoh: php artisan user:assign-role user@example.com staff");
    }
}
