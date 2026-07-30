<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kategori;

class MaterialRequestDetail extends Model
{
    protected $fillable = [
        'material_request_id',
        'barang_id',
        'kategori_id',
        'qty',
        'catatan'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function materialRequest()
    {
        return $this->belongsTo(MaterialRequest::class);
    }
}
