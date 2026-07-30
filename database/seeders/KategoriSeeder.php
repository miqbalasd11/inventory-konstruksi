<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['kode_kategori' => 'KAT001', 'nama_kategori' => 'Semen'],
            ['kode_kategori' => 'KAT002', 'nama_kategori' => 'Besi'],
            ['kode_kategori' => 'KAT003', 'nama_kategori' => 'Pasir'],
            ['kode_kategori' => 'KAT004', 'nama_kategori' => 'Keramik'],
            ['kode_kategori' => 'KAT005', 'nama_kategori' => 'Cat'],
            ['kode_kategori' => 'KAT006', 'nama_kategori' => 'Pipa'],
        ];

        foreach ($categories as $category) {
            Kategori::firstOrCreate(
                ['kode_kategori' => $category['kode_kategori']],
                ['nama_kategori' => $category['nama_kategori']]
            );
        }
    }
}
