<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanStatusHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengajuan_id',
        'user_id',
        'role',
        'status',
        'catatan',
        'anggaran',
    ];

    protected $casts = [
        'status' => 'string', // Enum: diproses_admin, verifikasi_ku, verifikasi_wd, pengesahan, disetujui, ditolak
        'role' => 'string', // Enum: admin, kepala_unit, wakil_dekan
        'anggaran' => 'decimal:2',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}