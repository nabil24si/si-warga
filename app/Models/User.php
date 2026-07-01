<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name', 'email', 'password', 'role', 'status_akun', 'rt_number', 'phone_number'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function warga()
    {
        return $this->hasOne(Warga::class);
    }

    public function pengumumans()
    {
        return $this->hasMany(Pengumuman::class);
    }

    public function surats()
    {
        return $this->hasMany(Surat::class);
    }

    public function laporans()
    {
        return $this->hasMany(Laporan::class);
    }

    public function kasKeuangans()
    {
        return $this->hasMany(KasKeuangan::class);
    }
}
