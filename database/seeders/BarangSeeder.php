<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Satuan;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Kategori::pluck('id', 'nama_kategori')->toArray();
        $units = Satuan::pluck('id', 'nama_satuan')->toArray();
        $suppliers = Supplier::pluck('id', 'kode_supplier')->toArray();

        $barangs = [
            [
                'kode_barang' => 'BRG001',
                'nama_barang' => 'Semen Portland',
                'kategori_id' => $categories['Semen'] ?? null,
                'satuan_id' => $units['Pcs'] ?? null,
                'supplier_id' => $suppliers['SUP001'] ?? null,
                'stok' => 120,
                'stok_minimum' => 20,
                'harga_beli' => 75000,
                'keterangan' => 'Semen untuk konstruksi umum',
            ],
            [
                'kode_barang' => 'BRG002',
                'nama_barang' => 'Besi Beton 10mm',
                'kategori_id' => $categories['Besi'] ?? null,
                'satuan_id' => $units['Pcs'] ?? null,
                'supplier_id' => $suppliers['SUP002'] ?? null,
                'stok' => 80,
                'stok_minimum' => 10,
                'harga_beli' => 95000,
                'keterangan' => 'Besi beton siap pakai',
            ],
            [
                'kode_barang' => 'BRG003',
                'nama_barang' => 'Pasir Silika',
                'kategori_id' => $categories['Pasir'] ?? null,
                'satuan_id' => $units['Meter'] ?? null,
                'supplier_id' => $suppliers['SUP003'] ?? null,
                'stok' => 200,
                'stok_minimum' => 30,
                'harga_beli' => 25000,
                'keterangan' => 'Pasir silika untuk adukan dan plester',
            ],
            [
                'kode_barang' => 'BRG004',
                'nama_barang' => 'Keramik 40x40',
                'kategori_id' => $categories['Keramik'] ?? null,
                'satuan_id' => $units['Dus'] ?? null,
                'supplier_id' => $suppliers['SUP004'] ?? null,
                'stok' => 50,
                'stok_minimum' => 5,
                'harga_beli' => 120000,
                'keterangan' => 'Keramik lantai ukuran 40x40',
            ],
            [
                'kode_barang' => 'BRG005',
                'nama_barang' => 'Cat Tembok',
                'kategori_id' => $categories['Cat'] ?? null,
                'satuan_id' => $units['Liter'] ?? null,
                'supplier_id' => $suppliers['SUP005'] ?? null,
                'stok' => 150,
                'stok_minimum' => 20,
                'harga_beli' => 65000,
                'keterangan' => 'Cat tembok interior',
            ],
            [
                'kode_barang' => 'BRG006',
                'nama_barang' => 'Pipa PVC 2 Inch',
                'kategori_id' => $categories['Pipa'] ?? null,
                'satuan_id' => $units['Meter'] ?? null,
                'supplier_id' => $suppliers['SUP001'] ?? null,
                'stok' => 90,
                'stok_minimum' => 15,
                'harga_beli' => 15000,
                'keterangan' => 'Pipa PVC untuk saluran air',
            ],
        ];

        foreach ($barangs as $barang) {
            if (! $barang['kategori_id'] || ! $barang['satuan_id'] || ! $barang['supplier_id']) {
                continue;
            }

            Barang::updateOrCreate(
                ['kode_barang' => $barang['kode_barang']],
                $barang
            );
        }
    }
}
