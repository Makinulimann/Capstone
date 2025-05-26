<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Pengajuan;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create users
        User::factory()->count(10)->create();
        User::factory()->create([
            'name' => 'Admin User',
            'nidn' => '110000000000001',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'department' => 'Teknik Informatika',
        ]);
        User::factory()->create([
            'name' => 'Kepala Unit',
            'nidn' => '120000000000002',
            'email' => 'kepala@example.com',
            'role' => 'kepala_unit',
            'department' => 'Sistem Informasi',
        ]);
        User::factory()->create([
            'name' => 'Wakil Dekan',
            'nidn' => '110000000000003',
            'email' => 'wakil@example.com',
            'role' => 'wakil_dekan',
            'department' => 'Teknik Informatika',
        ]);

        // Create pengajuans
        Pengajuan::factory()->count(20)->create();
    }
}