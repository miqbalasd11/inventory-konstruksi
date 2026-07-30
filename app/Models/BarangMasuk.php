<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    protected $fillable = [
        'kode_masuk',
        'tanggal_masuk',
        'supplier_id',
        'purchase_order_id',
        'user_id',
        'keterangan',
    ];

    //     public function barang() {
    //         return $this->hasMany(Barang::class);
    //     }

    public function details()
    {
        return $this->hasMany(
            BarangMasukDetail::class,
            'barang_masuk_id'
        );
    }

    public function supplier()
    {
        return $this->belongsTo(
            Supplier::class
        );
    }

    public function purchaseOrder()
    {
        return $this->belongsTo(
            PurchaseOrder::class
        );
    }

    public function user()
    {
        return $this->belongsTo(
            User::class
        );
    }
}
