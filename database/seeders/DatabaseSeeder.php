<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Seed Users Table
        $users = [
            ['name' => 'Ahmad Santoso', 'nidn' => '110123456789012', 'email' => 'ahmad.santoso@example.com', 'department' => 'Teknik Informatika', 'role' => 'dosen'],
            ['name' => 'Budi Pramana', 'nidn' => '120987654321098', 'email' => 'budi.pramana@example.com', 'department' => 'Sistem Informasi', 'role' => 'dosen'],
            ['name' => 'Citra Dewi', 'nidn' => '110234567890123', 'email' => 'citra.dewi@example.com', 'department' => 'Teknik Informatika', 'role' => 'admin'],
            ['name' => 'Dedi Kurniawan', 'nidn' => '120345678901234', 'email' => 'dedi.kurniawan@example.com', 'department' => 'Sistem Informasi', 'role' => 'kepala_unit'],
            ['name' => 'Eka Sari', 'nidn' => '110456789012345', 'email' => 'eka.sari@example.com', 'department' => 'Teknik Informatika', 'role' => 'wakil_dekan'],
            ['name' => 'Fajar Nugroho', 'nidn' => '120567890123456', 'email' => 'fajar.nugroho@example.com', 'department' => 'Sistem Informasi', 'role' => 'dosen'],
            ['name' => 'Gita Permata', 'nidn' => '110678901234567', 'email' => 'gita.permata@example.com', 'department' => 'Teknik Informatika', 'role' => 'dosen'],
            ['name' => 'Hadi Wijaya', 'nidn' => '120789012345678', 'email' => 'hadi.wijaya@example.com', 'department' => 'Sistem Informasi', 'role' => 'dosen'],
            ['name' => 'Indah Lestari', 'nidn' => '110890123456789', 'email' => 'indah.lestari@example.com', 'department' => 'Teknik Informatika', 'role' => 'admin'],
            ['name' => 'Joko Susilo', 'nidn' => '120901234567890', 'email' => 'joko.susilo@example.com', 'department' => 'Sistem Informasi', 'role' => 'kepala_unit'],
            ['name' => 'Kartika Sari', 'nidn' => '110123456789123', 'email' => 'kartika.sari@example.com', 'department' => 'Teknik Informatika', 'role' => 'dosen'],
            ['name' => 'Lina Marlina', 'nidn' => '120234567890234', 'email' => 'lina.marlina@example.com', 'department' => 'Sistem Informasi', 'role' => 'wakil_dekan'],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert([
                'name' => $user['name'],
                'nidn' => $user['nidn'],
                'email' => $user['email'],
                'department' => $user['department'],
                'role' => $user['role'],
                'password' => Hash::make('password123'),
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        // Seed Pengajuans Table
        $pengajuans = [
            [
                'user_id' => 1,
                'nama' => 'Sertifikasi Pemrograman Java',
                'tingkat' => 'Nasional',
                'lokasi' => 'Jakarta',
                'kategori' => 'Pemohonan',
                'periodeMulai' => '2025-01-10',
                'periodeSelesai' => '2025-01-15',
                'deskripsi' => 'Sertifikasi untuk keahlian pemrograman Java tingkat nasional.',
                'status' => 'diproses_admin',
                'created_at' => '2025-01-05',
            ],
            [
                'user_id' => 2,
                'nama' => 'Sertifikasi Jaringan Cisco CCNA',
                'tingkat' => 'Internasional',
                'lokasi' => 'Bandung',
                'kategori' => 'Reimburse',
                'periodeMulai' => '2025-02-20',
                'periodeSelesai' => '2025-02-25',
                'deskripsi' => 'Sertifikasi internasional untuk keahlian jaringan Cisco.',
                'status' => 'verifikasi_ku',
                'anggaran' => 5000000.00,
                'created_at' => '2025-02-01',
            ],
            [
                'user_id' => 3,
                'nama' => 'Sertifikasi Data Analyst',
                'tingkat' => 'Nasional',
                'lokasi' => 'Surabaya',
                'kategori' => 'Pemohonan',
                'periodeMulai' => '2025-03-15',
                'periodeSelesai' => '2025-03-20',
                'deskripsi' => 'Sertifikasi analisis data tingkat nasional.',
                'status' => 'pengesahan',
                'anggaran' => 4500000.00,
                'created_at' => '2025-03-01',
            ],
            [
                'user_id' => 4,
                'nama' => 'Sertifikasi AWS Cloud Practitioner',
                'tingkat' => 'Internasional',
                'lokasi' => 'Yogyakarta',
                'kategori' => 'Reimburse',
                'periodeMulai' => '2025-04-10',
                'periodeSelesai' => '2025-04-15',
                'deskripsi' => 'Sertifikasi cloud computing dari AWS.',
                'status' => 'pengesahan',
                'created_at' => '2025-04-01',
            ],
            [
                'user_id' => 5,
                'nama' => 'Sertifikasi UI/UX Design',
                'tingkat' => 'Nasional',
                'lokasi' => 'Jakarta',
                'kategori' => 'Pemohonan',
                'periodeMulai' => '2025-05-05',
                'periodeSelesai' => '2025-05-10',
                'deskripsi' => 'Sertifikasi desain antarmuka pengguna.',
                'status' => 'disetujui',
                'created_at' => '2025-05-01',
            ],
            [
                'user_id' => 6,
                'nama' => 'Sertifikasi Python Programming',
                'tingkat' => 'BNSP',
                'lokasi' => 'Semarang',
                'kategori' => 'Pemohonan',
                'periodeMulai' => '2025-06-15',
                'periodeSelesai' => '2025-06-20',
                'deskripsi' => 'Sertifikasi pemrograman Python oleh BNSP.',
                'status' => 'ditolak',
                'catatan' => 'Dokumen tidak lengkap.',
                'created_at' => '2025-06-01',
            ],
            [
                'user_id' => 7,
                'nama' => 'Sertifikasi Database Administrator',
                'tingkat' => 'Nasional',
                'lokasi' => 'Medan',
                'kategori' => 'Reimburse',
                'periodeMulai' => '2025-07-10',
                'periodeSelesai' => '2025-07-15',
                'deskripsi' => 'Sertifikasi untuk pengelolaan basis data.',
                'status' => 'diproses_admin',
                'created_at' => '2025-07-01',
            ],
            [
                'user_id' => 8,
                'nama' => 'Sertifikasi Cyber Security',
                'tingkat' => 'Internasional',
                'lokasi' => 'Denpasar',
                'kategori' => 'Pemohonan',
                'periodeMulai' => '2025-08-20',
                'periodeSelesai' => '2025-08-25',
                'deskripsi' => 'Sertifikasi keamanan siber tingkat internasional.',
                'status' => 'verifikasi_ku',
                'anggaran' => 6000000.00,
                'created_at' => '2025-08-01',
            ],
            [
                'user_id' => 9,
                'nama' => 'Sertifikasi Machine Learning',
                'tingkat' => 'Nasional',
                'lokasi' => 'Makassar',
                'kategori' => 'Reimburse',
                'periodeMulai' => '2025-09-10',
                'periodeSelesai' => '2025-09-15',
                'deskripsi' => 'Sertifikasi untuk keahlian machine learning.',
                'status' => 'pengesahan',
                'anggaran' => 5500000.00,
                'created_at' => '2025-09-01',
            ],
            [
                'user_id' => 10,
                'nama' => 'Sertifikasi Scrum Master',
                'tingkat' => 'Internasional',
                'lokasi' => 'Jakarta',
                'kategori' => 'Pemohonan',
                'periodeMulai' => '2025-10-05',
                'periodeSelesai' => '2025-10-10',
                'deskripsi' => 'Sertifikasi manajemen proyek Scrum.',
                'status' => 'pengesahan',
                'created_at' => '2025-10-01',
            ],
            [
                'user_id' => 11,
                'nama' => 'Sertifikasi ITIL Foundation',
                'tingkat' => 'Internasional',
                'lokasi' => 'Surabaya',
                'kategori' => 'Reimburse',
                'periodeMulai' => '2025-11-15',
                'periodeSelesai' => '2025-11-20',
                'deskripsi' => 'Sertifikasi manajemen layanan IT.',
                'status' => 'disetujui',
                'created_at' => '2025-11-01',
            ],
            [
                'user_id' => 12,
                'nama' => 'Sertifikasi Ethical Hacking',
                'tingkat' => 'Internasional',
                'lokasi' => 'Bandung',
                'kategori' => 'Pemohonan',
                'periodeMulai' => '2025-12-10',
                'periodeSelesai' => '2025-12-15',
                'deskripsi' => 'Sertifikasi untuk keahlian ethical hacking.',
                'status' => 'ditolak',
                'catatan' => 'Anggaran melebihi batas.',
                'created_at' => '2025-12-01',
            ],
        ];

        foreach ($pengajuans as $pengajuan) {
            DB::table('pengajuans')->insert([
                'user_id' => $pengajuan['user_id'],
                'nama' => $pengajuan['nama'],
                'tingkat' => $pengajuan['tingkat'],
                'lokasi' => $pengajuan['lokasi'],
                'kategori' => $pengajuan['kategori'],
                'periodeMulai' => $pengajuan['periodeMulai'],
                'periodeSelesai' => $pengajuan['periodeSelesai'],
                'deskripsi' => $pengajuan['deskripsi'],
                'status' => $pengajuan['status'],
                'catatan' => $pengajuan['catatan'] ?? null,
                'anggaran' => $pengajuan['anggaran'] ?? null,
                'created_at' => Carbon::parse($pengajuan['created_at']),
                'updated_at' => Carbon::parse($pengajuan['created_at']),
            ]);
        }

        // Seed Pengajuan Status History Table
        $statusHistory = [
            ['pengajuan_id' => 1, 'user_id' => 3, 'role' => 'admin', 'status' => 'diproses_admin', 'catatan' => null, 'anggaran' => null],
            ['pengajuan_id' => 2, 'user_id' => 4, 'role' => 'kepala_unit', 'status' => 'verifikasi_ku', 'catatan' => null, 'anggaran' => 5000000.00],
            ['pengajuan_id' => 3, 'user_id' => 5, 'role' => 'wakil_dekan', 'status' => 'pengesahan', 'catatan' => null, 'anggaran' => 4500000.00],
            ['pengajuan_id' => 4, 'user_id' => 3, 'role' => 'admin', 'status' => 'diproses_admin', 'catatan' => null, 'anggaran' => null],
            ['pengajuan_id' => 4, 'user_id' => 4, 'role' => 'kepala_unit', 'status' => 'verifikasi_ku', 'catatan' => null, 'anggaran' => 3000000.00],
            ['pengajuan_id' => 4, 'user_id' => 5, 'role' => 'wakil_dekan', 'status' => 'pengesahan', 'catatan' => null, 'anggaran' => null],
            ['pengajuan_id' => 5, 'user_id' => 3, 'role' => 'admin', 'status' => 'diproses_admin', 'catatan' => null, 'anggaran' => null],
            ['pengajuan_id' => 5, 'user_id' => 4, 'role' => 'kepala_unit', 'status' => 'verifikasi_ku', 'catatan' => null, 'anggaran' => 4000000.00],
            ['pengajuan_id' => 5, 'user_id' => 5, 'role' => 'wakil_dekan', 'status' => 'disetujui', 'catatan' => null, 'anggaran' => null],
            ['pengajuan_id' => 6, 'user_id' => 3, 'role' => 'admin', 'status' => 'diproses_admin', 'catatan' => null, 'anggaran' => null],
            ['pengajuan_id' => 6, 'user_id' => 4, 'role' => 'kepala_unit', 'status' => 'ditolak', 'catatan' => 'Dokumen tidak lengkap.', 'anggaran' => null],
            ['pengajuan_id' => 7, 'user_id' => 3, 'role' => 'admin', 'status' => 'diproses_admin', 'catatan' => null, 'anggaran' => null],
            ['pengajuan_id' => 8, 'user_id' => 4, 'role' => 'kepala_unit', 'status' => 'verifikasi_ku', 'catatan' => null, 'anggaran' => 6000000.00],
            ['pengajuan_id' => 9, 'user_id' => 5, 'role' => 'wakil_dekan', 'status' => 'pengesahan', 'catatan' => null, 'anggaran' => 5500000.00],
            ['pengajuan_id' => 10, 'user_id' => 3, 'role' => 'admin', 'status' => 'diproses_admin', 'catatan' => null, 'anggaran' => null],
            ['pengajuan_id' => 11, 'user_id' => 4, 'role' => 'kepala_unit', 'status' => 'verifikasi_ku', 'catatan' => null, 'anggaran' => 3500000.00],
            ['pengajuan_id' => 11, 'user_id' => 5, 'role' => 'wakil_dekan', 'status' => 'disetujui', 'catatan' => null, 'anggaran' => null],
            ['pengajuan_id' => 12, 'user_id' => 3, 'role' => 'admin', 'status' => 'diproses_admin', 'catatan' => null, 'anggaran' => null],
            ['pengajuan_id' => 12, 'user_id' => 4, 'role' => 'kepala_unit', 'status' => 'ditolak', 'catatan' => 'Anggaran melebihi batas.', 'anggaran' => null],
        ];

        foreach ($statusHistory as $history) {
            DB::table('pengajuan_status_history')->insert([
                'pengajuan_id' => $history['pengajuan_id'],
                'user_id' => $history['user_id'],
                'role' => $history['role'],
                'status' => $history['status'],
                'catatan' => $history['catatan'],
                'anggaran' => $history['anggaran'],
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}