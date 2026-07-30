<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderDetail extends Model
{
    protected $fillable = [
        'purchase_order_id',
        'barang_id',
        'qty',
        'harga',
        'subtotal'
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(
            PurchaseOrder::class
        );
    }

    public function barang()
    {
        return $this->belongsTo(
            Barang::class
        );
    }
}