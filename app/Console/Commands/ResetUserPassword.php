<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetUserPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:reset-password {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset user password';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("❌ User dengan email '{$email}' tidak ditemukan!");
            return;
        }

        $user->update([
            'password' => Hash::make($password)
        ]);

        $this->info("✅ Password untuk {$user->name} ({$email}) berhasil direset!");
        $this->line("🔑 Password baru: {$password}");
        
        // Test the new password
        if (Hash::check($password, $user->fresh()->password)) {
            $this->info("🎉 Password baru sudah bisa digunakan untuk login!");
        }
    }
}
