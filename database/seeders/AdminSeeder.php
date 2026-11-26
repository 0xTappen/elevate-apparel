<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! config('elevate.admin_email') || ! config('elevate.admin_password')) {
            $this->command?->warn('Admin belum dibuat. Isi ADMIN_EMAIL dan ADMIN_PASSWORD di .env lalu jalankan seeder lagi.');

            return;
        }

        User::updateOrCreate(['email' => config('elevate.admin_email')], [
            'name' => config('elevate.admin_name'),
            'password' => Hash::make(config('elevate.admin_password')),
            'is_admin' => true,
        ]);
    }
}
