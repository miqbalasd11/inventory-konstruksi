<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MaterialRequest;

class PurchaseOrder extends Model
{
   protected $fillable = [
    'material_request_id',
    'nomor_po',
    'supplier_id',
    'user_id',
    'tanggal_po',
    'status',
    'keterangan',
    'total'
];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function materialRequest()
    {
        return $this->belongsTo(MaterialRequest::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(
            PurchaseOrderDetail::class
        );
    }


}