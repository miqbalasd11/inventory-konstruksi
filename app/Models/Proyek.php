<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    protected $fillable = [
        'kode_proyek',
        'nama_proyek',
        'lokasi',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
    ];

    public function barangKeluar()
    {
        return $this->hasMany(
            BarangKeluar::class
        );
    }
    public function materialRequests()
{
    return $this->hasMany(
        MaterialRequest::class
    );
}
}
