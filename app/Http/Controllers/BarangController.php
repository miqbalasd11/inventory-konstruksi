<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Satuan;
use Illuminate\Http\Request;
use App\Helpers\ActivityHelper;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::with([
            'kategori',
            'satuan'
        ])
        ->latest()
        ->get();

        return view('barang.index', compact('barang'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        $satuan   = Satuan::all();

        return view(
            'barang.create',
            compact(
                'kategori',
                'satuan'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'kategori_id' => 'required',
            'satuan_id'   => 'required',
        ]);

        $barang = Barang::create([
             'kode_barang' => 'BRG-' . now()->format('YmdHis'),
            'nama_barang'  => $request->nama_barang,
            'kategori_id'  => $request->kategori_id,
            'satuan_id'    => $request->satuan_id,

            // default supplier
            'supplier_id'  => 1,

            'stok'         => $request->stok ?? 0,
            'stok_minimum' => $request->stok_minimum ?? 0,
            'harga_beli'   => 0,
            'keterangan'   => $request->keterangan,
        ]);

        ActivityHelper::log(
            'Tambah Barang',
            'Menambahkan barang ' . $barang->nama_barang
        );

        return redirect()
            ->route('barang.index')
            ->with(
                'success',
                'Barang berhasil ditambahkan'
            );
    }

    public function show(Barang $barang)
    {
        $barang->load([
            'kategori',
            'satuan'
        ]);

        return view(
            'barang.show',
            compact('barang')
        );
    }

    public function edit(Barang $barang)
    {
        $kategori = Kategori::all();
        $satuan   = Satuan::all();

        return view(
            'barang.edit',
            compact(
                'barang',
                'kategori',
                'satuan'
            )
        );
    }

    public function update(
        Request $request,
        Barang $barang
    ) {
        $request->validate([
            'kode_barang' =>
                'required|unique:barangs,kode_barang,' .
                $barang->id,

            'nama_barang' => 'required',
            'kategori_id' => 'required',
            'satuan_id'   => 'required',
        ]);

        $barang->update([
            'kode_barang'  => $request->kode_barang,
            'nama_barang'  => $request->nama_barang,
            'kategori_id'  => $request->kategori_id,
            'satuan_id'    => $request->satuan_id,

            'stok'         => $request->stok ?? 0,
            'stok_minimum' => $request->stok_minimum ?? 0,

            'keterangan'   => $request->keterangan,
        ]);

        ActivityHelper::log(
            'Update Barang',
            'Mengubah data barang ' . $barang->nama_barang
        );

        return redirect()
            ->route('barang.index')
            ->with(
                'success',
                'Barang berhasil diperbarui'
            );
    }

    public function destroy(Barang $barang)
    {
        ActivityHelper::log(
            'Hapus Barang',
            'Menghapus barang ' . $barang->nama_barang
        );

        $barang->delete();

        return redirect()
            ->route('barang.index')
            ->with(
                'success',
                'Barang berhasil dihapus'
            );
    }
}