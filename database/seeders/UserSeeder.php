<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Generate 15 users with specific role distribution
        $roles = [
            ['name' => 'Admin User 1', 'email' => 'admin1@example.com', 'role' => 'admin'],
            ['name' => 'Admin User 2', 'email' => 'admin2@example.com', 'role' => 'admin'],
            ['name' => 'Dosen User 1', 'email' => 'dosen1@example.com', 'role' => 'dosen'],
            ['name' => 'Dosen User 2', 'email' => 'dosen2@example.com', 'role' => 'dosen'],
            ['name' => 'Dosen User 3', 'email' => 'dosen3@example.com', 'role' => 'dosen'],
            ['name' => 'Dosen User 4', 'email' => 'dosen4@example.com', 'role' => 'dosen'],
            ['name' => 'Dosen User 5', 'email' => 'dosen5@example.com', 'role' => 'dosen'],
            ['name' => 'Kepala Unit 1', 'email' => 'kepalaunit1@example.com', 'role' => 'kepala_unit'],
            ['name' => 'Kepala Unit 2', 'email' => 'kepalaunit2@example.com', 'role' => 'kepala_unit'],
            ['name' => 'Kepala Unit 3', 'email' => 'kepalaunit3@example.com', 'role' => 'kepala_unit'],
            ['name' => 'Wakil Dekan 1', 'email' => 'wakildekan1@example.com', 'role' => 'wakil_dekan'],
            ['name' => 'Wakil Dekan 2', 'email' => 'wakildekan2@example.com', 'role' => 'wakil_dekan'],
            ['name' => 'Wakil Dekan 3', 'email' => 'wakildekan3@example.com', 'role' => 'wakil_dekan'],
            ['name' => 'Dosen User 6', 'email' => 'dosen6@example.com', 'role' => 'dosen'],
            ['name' => 'Dosen User 7', 'email' => 'dosen7@example.com', 'role' => 'dosen'],
        ];

        foreach ($roles as $userData) {
            User::factory()->create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'role' => $userData['role'],
            ]);
        }
    }
}