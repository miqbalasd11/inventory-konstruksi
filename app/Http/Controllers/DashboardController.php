<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\PermintaanBarang;
use App\Models\Proyek;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | MASTER DATA
        |--------------------------------------------------------------------------
        */

        $totalBarang = Barang::count();

        $totalSupplier = Supplier::count();

        $totalProyek = Proyek::count();

        $totalUser = User::count();

        $proyekAktif = Proyek::where(
            'status',
            'Aktif'
        )->count();

        /*
        |--------------------------------------------------------------------------
        | STOK
        |--------------------------------------------------------------------------
        */

        $stokMenipis = Barang::whereColumn(
            'stok',
            '<=',
            'stok_minimum'
        )->count();

        $stokKritis = Barang::whereColumn(
            'stok',
            '<=',
            'stok_minimum'
        )
        ->orderBy('stok')
        ->take(5)
        ->get();

        $barangTerbanyak = Barang::orderByDesc(
            'stok'
        )
        ->take(5)
        ->get();

        $totalNilaiPersediaan = Barang::sum(
            DB::raw('stok * harga_beli')
        );

        /*
        |--------------------------------------------------------------------------
        | BARANG MASUK
        |--------------------------------------------------------------------------
        */

        $aktivitasMasuk = BarangMasuk::with([
            'details.barang',
            'supplier',
            'user'
        ])
        ->latest()
        ->take(10)
        ->get();

        /*
        |--------------------------------------------------------------------------
        | BARANG KELUAR
        |--------------------------------------------------------------------------
        */

        $aktivitasKeluar = BarangKeluar::with([
            'details.barang',
            'proyek',
            'user'
        ])
        ->latest()
        ->take(10)
        ->get();

        /*
        |--------------------------------------------------------------------------
        | TOTAL TRANSAKSI
        |--------------------------------------------------------------------------
        */

        $totalBarangMasuk = BarangMasuk::count();

        $totalBarangKeluar = BarangKeluar::count();

        /*
        |--------------------------------------------------------------------------
        | PERMINTAAN BARANG
        |--------------------------------------------------------------------------
        */

        $permintaanPending = PermintaanBarang::where(
            'status',
            'Menunggu'
        )->count();

        $permintaanDisetujui = PermintaanBarang::where(
            'status',
            'Disetujui'
        )->count();

        /*
        |--------------------------------------------------------------------------
        | TOP MATERIAL
        |--------------------------------------------------------------------------
        */

        $topMaterial = collect();

        /*
        |--------------------------------------------------------------------------
        | PROYEK TERAKTIF
        |--------------------------------------------------------------------------
        */

        $proyekTeraktif = Proyek::latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | GRAFIK
        |--------------------------------------------------------------------------
        */

        $grafikMasuk = BarangMasuk::selectRaw(
            'MONTH(tanggal_masuk) as bulan,
             COUNT(*) as total'
        )
        ->groupBy('bulan')
        ->pluck('total');

        $grafikKeluar = BarangKeluar::selectRaw(
            'MONTH(tanggal_keluar) as bulan,
             COUNT(*) as total'
        )
        ->groupBy('bulan')
        ->pluck('total');

        return view(
            'dashboard.index',
            compact(
                'totalBarang',
                'totalSupplier',
                'totalBarangMasuk',
                'totalBarangKeluar',
                'totalNilaiPersediaan',
                'stokMenipis',
                'stokKritis',
                'barangTerbanyak',
                'aktivitasMasuk',
                'aktivitasKeluar',
                'totalProyek',
                'totalUser',
                'proyekAktif',
                'permintaanPending',
                'permintaanDisetujui',
                'topMaterial',
                'proyekTeraktif',
                'grafikMasuk',
                'grafikKeluar'
            )
        );
    }

    public function lapangan()
    {
        $pending = PermintaanBarang::where(
            'user_id',
            Auth::id()
        )
        ->where(
            'status',
            'Menunggu'
        )
        ->count();

        $approved = PermintaanBarang::where(
            'user_id',
            Auth::id()
        )
        ->where(
            'status',
            'Disetujui'
        )
        ->count();

        $total = PermintaanBarang::where(
            'user_id',
            Auth::id()
        )->count();

        return view(
            'dashboard.lapangan',
            compact(
                'pending',
                'approved',
                'total'
            )
        );
    }

    public function manager()
    {
        $pending = PermintaanBarang::where(
            'status',
            'Menunggu'
        )->count();

        $approved = PermintaanBarang::where(
            'status',
            'Disetujui'
        )->count();

        $rejected = PermintaanBarang::where(
            'status',
            'Ditolak'
        )->count();

        $permintaanTerbaru = PermintaanBarang::with([
            'proyek',
            'user'
        ])
        ->latest()
        ->take(10)
        ->get();

        return view(
            'dashboard.manager',
            compact(
                'pending',
                'approved',
                'rejected',
                'permintaanTerbaru'
            )
        );
    }
}