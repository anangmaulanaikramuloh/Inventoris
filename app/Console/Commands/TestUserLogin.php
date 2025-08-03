<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestUserLogin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:login {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test user login credentials';

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

        $this->info("✅ User ditemukan:");
        $this->line("Nama: {$user->name}");
        $this->line("Email: {$user->email}");
        $this->line("Role: " . $user->getRoleNames()->implode(', '));
        $this->line("Terdaftar: " . $user->created_at->format('d/m/Y H:i'));

        if (Hash::check($password, $user->password)) {
            $this->info("✅ Password '{$password}' BENAR!");
            $this->info("🎉 Login akan berhasil!");
        } else {
            $this->error("❌ Password '{$password}' SALAH!");
            $this->line("🔧 Coba reset password atau gunakan password lain");
        }
    }
}
