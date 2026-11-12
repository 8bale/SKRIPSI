<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin Account
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator Mechanic',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // Standard User Account
        User::updateOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'Staff Gudang Mekanik',
                'password' => Hash::make('user123'),
                'role' => 'user',
            ]
        );

        // Akun Mekanik Regu 1
        User::updateOrCreate(
            ['email' => 'regu1@gmail.com'],
            [
                'name' => 'Mekanik Regu 1',
                'password' => Hash::make('regu123'),
                'role' => 'user',
            ]
        );

        // Akun Mekanik Regu 2
        User::updateOrCreate(
            ['email' => 'regu2@gmail.com'],
            [
                'name' => 'Mekanik Regu 2',
                'password' => Hash::make('regu2123'),
                'role' => 'user',
            ]
        );

        // Akun Mekanik Regu 3
        User::updateOrCreate(
            ['email' => 'regu3@gmail.com'],
            [
                'name' => 'Mekanik Regu 3',
                'password' => Hash::make('regu3123'),
                'role' => 'user',
            ]
        );

        // Akun Mekanik Non-Shift
        User::updateOrCreate(
            ['email' => 'nonshift@gmail.com'],
            [
                'name' => 'Mekanik Non-Shift',
                'password' => Hash::make('nonshift123'),
                'role' => 'user',
            ]
        );

        // Alias akun shift (tetap didukung untuk kompatibilitas login)
        User::updateOrCreate(
            ['email' => 'shift1@gmail.com'],
            [
                'name' => 'Mekanik Regu 1',
                'password' => Hash::make('shift123'),
                'role' => 'user',
            ]
        );
        User::updateOrCreate(
            ['email' => 'shift2@gmail.com'],
            [
                'name' => 'Mekanik Regu 2',
                'password' => Hash::make('shift2123'),
                'role' => 'user',
            ]
        );
        User::updateOrCreate(
            ['email' => 'shift3@gmail.com'],
            [
                'name' => 'Mekanik Regu 3',
                'password' => Hash::make('shift3123'),
                'role' => 'user',
            ]
        );
    }
}
