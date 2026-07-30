<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangKeluarDetail extends Model
{
    protected $fillable = [
        'barang_keluar_id',
        'barang_id',
        'qty',
        'catatan',
    ];

    public function barangKeluar()
    {
        return $this->belongsTo(
            BarangKeluar::class
        );
    }

    public function barang()
    {
        return $this->belongsTo(
            Barang::class
        );
    }
}