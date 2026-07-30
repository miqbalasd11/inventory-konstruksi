<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\BarangKeluarDetail;
use App\Models\PermintaanBarang;
use App\Models\Proyek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Helpers\ActivityHelper;

class PermintaanBarangController extends Controller
{
    public function index()
    {
        $query = PermintaanBarang::with([
            'barang',
            'proyek',
            'user',
        ])->latest();

        if (Auth::user()->role?->name === 'Staff Proyek') {
            $query->where('user_id', Auth::id());
        }

        $permintaan = $query->get();

        return view(
            'permintaan-barang.index',
            compact('permintaan')
        );
    }

    public function create()
    {
        $barang = Barang::all();
        $proyek = Proyek::all();

        return view(
            'permintaan-barang.create',
            compact(
                'barang',
                'proyek'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'barang_id' => 'required',
            'proyek_id' => 'required',
            'qty' => 'required|numeric|min:1',
            'keterangan' => 'nullable',
        ]);

        $last = PermintaanBarang::latest()->first();

        $nomor = $last
            ? intval(substr($last->kode_permintaan, -4)) + 1
            : 1;

        $kode =
            'PM-' .
            now()->format('Ymd') .
            '-' .
            str_pad($nomor, 4, '0', STR_PAD_LEFT);

        $permintaan = PermintaanBarang::create([
            'kode_permintaan' => $kode,
            'tanggal' => $request->tanggal,
            'barang_id' => $request->barang_id,
            'proyek_id' => $request->proyek_id,
            'qty' => $request->qty,
            'keterangan' => $request->keterangan,

            'status' => 'Menunggu',

            'user_id' => Auth::id(),
        ]);

        $barang = Barang::find($request->barang_id);

        ActivityHelper::log(
            'Permintaan Barang',
            'Mengajukan permintaan barang ' .
                $barang->nama_barang .
                ' sebanyak ' .
                $request->qty
        );

        Notification::create([
            'user_id' => Auth::id(),
            'judul' => 'Permintaan Barang',
            'pesan' => 'Permintaan barang berhasil dibuat : ' . $kode,
        ]);

        return redirect()
            ->route('permintaan-barang.index')
            ->with(
                'success',
                'Permintaan barang berhasil diajukan.'
            );
    }

    public function show(
        PermintaanBarang $permintaanBarang
    ) {
        return view(
            'permintaan-barang.show',
            compact('permintaanBarang')
        );
    }

    public function edit(
        PermintaanBarang $permintaanBarang
    ) {
        $barang = Barang::all();
        $proyek = Proyek::all();

        return view(
            'permintaan-barang.edit',
            compact(
                'permintaanBarang',
                'barang',
                'proyek'
            )
        );
    }

    public function update(
        Request $request,
        PermintaanBarang $permintaanBarang
    ) {
        $request->validate([
            'tanggal' => 'required|date',
            'barang_id' => 'required',
            'proyek_id' => 'required',
            'qty' => 'required|numeric|min:1',
        ]);

        $permintaanBarang->update([
            'tanggal' => $request->tanggal,
            'barang_id' => $request->barang_id,
            'proyek_id' => $request->proyek_id,
            'qty' => $request->qty,
            'keterangan' => $request->keterangan,
        ]);

        ActivityHelper::log(
            'Update Permintaan',
            'Mengubah permintaan ' .
                $permintaanBarang->kode_permintaan
        );

        Notification::create([
            'user_id' => Auth::id(),
            'judul' => 'Update Permintaan',
            'pesan' => 'Permintaan diperbarui : ' .
                $permintaanBarang->kode_permintaan,
        ]);
        return redirect()
            ->route('permintaan-barang.index')
            ->with(
                'success',
                'Data berhasil diperbarui.'
            );
    }

    public function destroy(
        PermintaanBarang $permintaanBarang
    ) {
        $permintaanBarang->delete();

        return redirect()
            ->route('permintaan-barang.index')
            ->with(
                'success',
                'Data berhasil dihapus.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | APPROVE PERMINTAAN
    |--------------------------------------------------------------------------
    */

    public function approve(
        PermintaanBarang $permintaanBarang
    ) {

        // Cegah approve ulang
        if ($permintaanBarang->status != 'Menunggu') {
            return back()->with(
                'error',
                'Permintaan sudah diproses.'
            );
        }

        $barang = Barang::findOrFail(
            $permintaanBarang->barang_id
        );

        // Cek stok
        if ($barang->stok < $permintaanBarang->qty) {
            return back()->with(
                'error',
                'Stok tidak mencukupi.'
            );
        }

        // Kurangi stok
        $barang->stok -= $permintaanBarang->qty;
        $barang->save();

        // Generate kode barang keluar
        $lastKeluar = BarangKeluar::orderBy('id', 'desc')->first();

        if ($lastKeluar) {
            $nomor = (int) substr($lastKeluar->nomor_keluar, -4) + 1;
        } else {
            $nomor = 1;
        }

        $kodeKeluar =
            'BK-' .
            now()->format('Ymd') .
            '-' .
            str_pad($nomor, 4, '0', STR_PAD_LEFT);

        // Simpan barang keluar otomatis
        $barangKeluar = BarangKeluar::create([
            'nomor_keluar' => $kodeKeluar,
            'tanggal_keluar' => now()->toDateString(),
            'proyek_id' => $permintaanBarang->proyek_id,
            'keterangan' => 'Permintaan Barang : ' .
                $permintaanBarang->kode_permintaan,
            'user_id' => Auth::id(),
        ]);

        BarangKeluarDetail::create([
            'barang_keluar_id' => $barangKeluar->id,
            'barang_id' => $permintaanBarang->barang_id,
            'qty' => $permintaanBarang->qty,
            'keterangan' => $permintaanBarang->keterangan,
        ]);

        // Update status
        $permintaanBarang->update([
            'status' => 'Disetujui',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return redirect()
            ->route('permintaan-barang.index')
            ->with(
                'success',
                'Permintaan berhasil disetujui.'
            );
    }

    public function reject(
        PermintaanBarang $permintaanBarang
    ) {

        // Cegah reject ulang
        if ($permintaanBarang->status != 'Menunggu') {
            return back()->with(
                'error',
                'Permintaan sudah diproses.'
            );
        }

        $permintaanBarang->update([
            'status' => 'Ditolak',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);
        ActivityHelper::log(
            'Hapus Permintaan',
            'Menghapus permintaan ' .
                $permintaanBarang->kode_permintaan
        );

        Notification::create([
            'user_id' => Auth::id(),
            'judul' => 'Hapus Permintaan',
            'pesan' => 'Permintaan dihapus : ' .
                $permintaanBarang->kode_permintaan,
        ]);
        return redirect()
            ->route('permintaan-barang.index')
            ->with(
                'success',
                'Permintaan berhasil ditolak.'
            );
    }
}
