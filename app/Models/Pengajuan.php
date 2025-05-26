<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',
        'tingkat',
        'lokasi',
        'kategori',
        'periodeMulai',
        'periodeSelesai',
        'deskripsi',
        'status',
        'catatan',
        'proposal',
        'bukti',
        'anggaran',
    ];

    protected $casts = [
        'periodeMulai' => 'date',
        'periodeSelesai' => 'date',
        'status' => 'string', // Enum: diproses_admin, verifikasi_ku, verifikasi_wd, pengesahan, disetujui, ditolak
        'kategori' => 'string', // Enum: Pemohonan, Reimburse
        'anggaran' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statusHistories()
    {
        return $this->hasMany(PengajuanStatusHistory::class);
    }

    // Helper method to get the latest status update
    public function latestStatusHistory()
    {
        return $this->statusHistories()->latest()->first();
    }
}