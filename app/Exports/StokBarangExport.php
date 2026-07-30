<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StokBarangExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Barang::select(
            'kode_barang',
            'nama_barang',
            'stok',
            'stok_minimum'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Kode Barang',
            'Nama Barang',
            'Stok',
            'Stok Minimum',
        ];
    }
}