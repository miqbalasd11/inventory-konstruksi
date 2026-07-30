<?php

namespace Database\Seeders;

use App\Models\Satuan;
use Illuminate\Database\Seeder;

class SatuanSeeder extends Seeder
{
    public function run(): void
    {
        $satuans = [
            ['kode_satuan' => 'ST001', 'nama_satuan' => 'Pcs', 'keterangan' => 'Unit per buah'],
            ['kode_satuan' => 'ST002', 'nama_satuan' => 'Meter', 'keterangan' => 'Satuan panjang'],
            ['kode_satuan' => 'ST003', 'nama_satuan' => 'Roll', 'keterangan' => 'Satuan gulungan'],
            ['kode_satuan' => 'ST004', 'nama_satuan' => 'Liter', 'keterangan' => 'Volume cairan'],
            ['kode_satuan' => 'ST005', 'nama_satuan' => 'Dus', 'keterangan' => 'Satuan kotak'],
            ['kode_satuan' => 'ST006', 'nama_satuan' => 'Bungkus', 'keterangan' => 'Satuan kemasan'],
        ];

        foreach ($satuans as $satuan) {
            Satuan::updateOrCreate(
                ['kode_satuan' => $satuan['kode_satuan']],
                $satuan
            );
        }
    }
}
