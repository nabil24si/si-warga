<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class KasKeuangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'jenis_transaksi', 'kategori', 'nominal', 'tanggal_transaksi', 'keterangan'
    ];

    protected $casts = [
        'tanggal_transaksi' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
