<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermintaanBarang extends Model
{
    protected $fillable = [
        'kode_permintaan',
        'tanggal',
        'proyek_id',
        'barang_id',
        'qty',
        'keterangan',
        'status',
        'user_id',
        'approved_by',
        'approved_at',
        'catatan_manager',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'approved_at' => 'datetime',
    ];

    public function proyek()
    {
        return $this->belongsTo(Proyek::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(
            User::class,
            'approved_by'
        );
    }
}
