<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            ['kode_supplier' => 'SUP001', 'nama_supplier' => 'PT Konstruksi Nusantara', 'telepon' => '021-5551234', 'email' => 'sales@knusantara.co.id', 'alamat' => 'Jl. Merdeka No. 10, Jakarta'],
            ['kode_supplier' => 'SUP002', 'nama_supplier' => 'CV Bahan Bangunan Jaya', 'telepon' => '021-5552345', 'email' => 'info@bbjaya.com', 'alamat' => 'Jl. Sudirman No. 20, Jakarta'],
            ['kode_supplier' => 'SUP003', 'nama_supplier' => 'PT Material Prima', 'telepon' => '021-5553456', 'email' => 'contact@materialprima.id', 'alamat' => 'Jl. Gatot Subroto No. 35, Jakarta'],
            ['kode_supplier' => 'SUP004', 'nama_supplier' => 'CV Sumber Karya', 'telepon' => '021-5554567', 'email' => 'cs@sumberkarya.com', 'alamat' => 'Jl. Thamrin No. 45, Jakarta'],
            ['kode_supplier' => 'SUP005', 'nama_supplier' => 'PT Bangun Sejahtera', 'telepon' => '021-5555678', 'email' => 'admin@bangunsejahtera.com', 'alamat' => 'Jl. Hayam Wuruk No. 88, Jakarta'],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::updateOrCreate(
                ['kode_supplier' => $supplier['kode_supplier']],
                $supplier
            );
        }
    }
}
