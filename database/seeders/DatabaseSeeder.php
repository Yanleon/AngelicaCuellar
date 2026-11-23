<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $email = (string) config('portfolio.admin_email');
        $passwordHash = (string) config('portfolio.admin_password_hash');

        if ($email === '' || $passwordHash === '') {
            throw new \RuntimeException('Define ADMIN_EMAIL y ADMIN_PASSWORD_HASH en .env antes de ejecutar el seeder.');
        }

        // firstOrCreate: no sobrescribe la clave de un administrador que ya existe.
        User::firstOrCreate(
            ['email' => $email],
            ['name' => 'Angélica Cuéllar', 'password' => $passwordHash]
        );
    }
}
