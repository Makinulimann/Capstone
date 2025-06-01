<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        $nidnPrefix = $this->faker->randomElement(['11', '12']);
        $department = $nidnPrefix === '11' ? 'Teknik Informatika' : 'Sistem Informasi';
        $nidn = $nidnPrefix . str_pad($this->faker->unique()->numberBetween(100000000, 999999999), 13, '0', STR_PAD_LEFT);

        return [
            'name' => $this->faker->name(),
            'nidn' => $nidn,
            'email' => $this->faker->unique()->safeEmail(),
            'photo' => null,
            'department' => $department,
            'role' => $this->faker->randomElement(['dosen', 'admin', 'kepala_unit', 'wakil_dekan']),
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // Default password
            'remember_token' => Str::random(10),
        ];
    }
}