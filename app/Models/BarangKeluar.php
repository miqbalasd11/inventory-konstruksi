<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    protected $fillable = [
        'nomor_keluar',
        'tanggal_keluar',
        'proyek_id',
        'material_request_id',
        'keterangan',
        'user_id',
    ];

    public function details()
    {
        return $this->hasMany(
            BarangKeluarDetail::class,
            'barang_keluar_id'
        );
    }

    public function proyek()
    {
        return $this->belongsTo(
            Proyek::class
        );
    }

    public function materialRequest()
    {
        return $this->belongsTo(
            MaterialRequest::class
        );
    }

    public function user()
    {
        return $this->belongsTo(
            User::class
        );
    }
}
