<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialRequest extends Model
{
    protected $fillable = [
        'nomor_mr',
        'user_id',
        'approved_by',
        'approved_at',
        'approval_note',
        'tanggal_request',
        'status',
        'keterangan'
    ];

    public function proyek()
    {
        return $this->belongsTo(Proyek::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(MaterialRequestDetail::class);
    }

    public function barangs()
    {
        return $this->belongsToMany(
            Barang::class,
            'material_request_details',
            'material_request_id',
            'barang_id'
        )->withPivot('qty', 'catatan');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function approver()
    {
        return $this->belongsTo(
            User::class,
            'approved_by'
        );
    }

    public function purchaseOrders()
    {
        return $this->hasMany(
            PurchaseOrder::class
        );
    }
}
