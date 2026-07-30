<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori_id',
        'satuan_id',
        'supplier_id',
        'stok',
        'stok_minimum',
        'harga_beli',
        'keterangan',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function materialRequestDetails()
    {
        return $this->hasMany(MaterialRequestDetail::class);
    }

    public function purchaseOrderDetails()
    {
        return $this->hasMany(PurchaseOrderDetail::class);
    }

    public function barangMasukDetails()
    {
        return $this->hasMany(BarangMasukDetail::class);
    }

    public function barangKeluarDetails()
    {
        return $this->hasMany(BarangKeluarDetail::class);
    }
}