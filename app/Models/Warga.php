<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Warga extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'nik', 'no_kk', 'nama_lengkap', 'tempat_lahir',
        'tanggal_lahir', 'jenis_kelamin', 'agama', 'pekerjaan',
        'status_perkawinan', 'rt_number'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
