<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanStatusHistory extends Model
{
    protected $table = 'pengajuan_status_history';

    protected $fillable = [
        'pengajuan_id',
        'user_id',
        'role',
        'status',
        'catatan',
        'anggaran',
    ];

    protected $casts = [
        'anggaran' => 'decimal:10,2',
        'updated_at' => 'datetime',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}