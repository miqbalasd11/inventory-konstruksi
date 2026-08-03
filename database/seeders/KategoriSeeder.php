<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'nama_kategori' => 'Semen'
            ],

            [
                'nama_kategori' => 'Besi'
            ],

            [
                'nama_kategori' => 'Pasir'
            ],

            [
                'nama_kategori' => 'Keramik'
            ],

            [
                'nama_kategori' => 'Cat'
            ],

            [
                'nama_kategori' => 'Pipa'
            ],

        ];

        foreach ($categories as $category) {
            // Pembuatan kode_kategori secara otomatis
            $lastCategory = Kategori::latest('id')->first();
            $nextNumber = $lastCategory ? ($lastCategory->id + 1) : 1;
            $paddedNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            $kodeOtomatis = 'KTG-' . $paddedNumber;

            Kategori::firstOrCreate(
                ['kode_kategori' => $kodeOtomatis],
                ['nama_kategori' => $category['nama_kategori']]
            );
        }
    }
}
