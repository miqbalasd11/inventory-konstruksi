<?php

namespace Database\Seeders;

use App\Models\Proyek;
use Illuminate\Database\Seeder;

class ProyekSeeder extends Seeder
{
    public function run(): void
    {
        $proyeks = [
            ['kode_proyek' => 'PRY001', 'nama_proyek' => 'Renovasi Gedung A', 'lokasi' => 'Jakarta Pusat', 'tanggal_mulai' => '2026-06-01', 'tanggal_selesai' => '2026-07-31', 'status' => 'Aktif'],
            ['kode_proyek' => 'PRY002', 'nama_proyek' => 'Pembangunan Gudang', 'lokasi' => 'Bekasi', 'tanggal_mulai' => '2026-05-10', 'tanggal_selesai' => null, 'status' => 'Aktif'],
            ['kode_proyek' => 'PRY003', 'nama_proyek' => 'Perbaikan Jalan', 'lokasi' => 'Depok', 'tanggal_mulai' => '2026-04-15', 'tanggal_selesai' => '2026-06-15', 'status' => 'Selesai'],
            ['kode_proyek' => 'PRY004', 'nama_proyek' => 'Renovasi Sekolah', 'lokasi' => 'Tangerang', 'tanggal_mulai' => '2026-06-20', 'tanggal_selesai' => null, 'status' => 'Pending'],
        ];

        foreach ($proyeks as $proyek) {
            Proyek::updateOrCreate(
                ['kode_proyek' => $proyek['kode_proyek']],
                $proyek
            );
        }
    }
}
