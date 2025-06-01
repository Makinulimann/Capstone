<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'nidn',
        'email',
        'photo',
        'department',
        'role',
        'email_verified_at',
        'password',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'role' => 'string', // Enum: dosen, admin, kepala_unit, wakil_dekan
    ];

    // Relationships
    public function pengajuans()
    {
        return $this->hasMany(Pengajuan::class);
    }

    public function statusHistories()
    {
        return $this->hasMany(PengajuanStatusHistory::class);
    }

    // Helper method to check roles
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    // Accessor for department based on NIDN (if needed, since we already have a trigger)
    public function getDepartmentAttribute($value)
    {
        if (!$value && $this->nidn) {
            $prefix = substr($this->nidn, 0, 2);
            return $prefix === '11' ? 'Teknik Informatika' : ($prefix === '12' ? 'Sistem Informasi' : null);
        }
        return $value;
    }
}