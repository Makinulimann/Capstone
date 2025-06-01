<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class PengajuanFactory extends Factory
{
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-1 year', 'now');
        $endDate = $this->faker->dateTimeBetween($startDate, '+1 year');

        return [
            'user_id' => User::where('role', 'dosen')->inRandomOrder()->first()->id,
            'nama' => $this->faker->sentence(3),
            'tingkat' => $this->faker->randomElement(['BNSP', 'Nasional', 'Internasional']),
            'lokasi' => $this->faker->city(),
            'kategori' => $this->faker->randomElement(['Pemohonan', 'Reimburse']),
            'periodeMulai' => $startDate,
            'periodeSelesai' => $endDate,
            'deskripsi' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(['diproses_admin', 'verifikasi_ku', 'verifikasi_wd', 'pengesahan', 'disetujui', 'ditolak']),
            'catatan' => $this->faker->optional()->sentence(),
            'proposal' => $this->faker->optional()->filePath(),
            'bukti' => $this->faker->optional()->filePath(),
            'anggaran' => $this->faker->optional()->randomFloat(2, 100000, 5000000),
        ];
    }
}