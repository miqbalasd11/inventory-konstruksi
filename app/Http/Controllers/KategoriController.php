<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Helpers\ActivityHelper;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::latest()->get();

        return view(
            'kategori.index',
            compact('kategori')
        );
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_kategori' => 'nullable|unique:kategoris',
            'nama_kategori' => 'required',
        ]);

        // Pembuatan kode_kategori secara otomatis
            $lastCategory = Kategori::latest('id')->first();
            $nextNumber = $lastCategory ? ($lastCategory->id + 1) : 1;
            $paddedNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            $kodeOtomatis = 'KTG-' . $paddedNumber;

        $kategori = Kategori::create([
            'kode_kategori' => $kodeOtomatis,
            'nama_kategori' => $request->nama_kategori,
            'keterangan' => $request->keterangan,
        ]);

        ActivityHelper::log(
            'Tambah Kategori',
            'Menambahkan kategori ' .
            $kategori->nama_kategori
        );

        return redirect()
            ->route('kategori.index')
            ->with(
                'success',
                'Kategori berhasil ditambahkan'
            );
    }

    public function show(
        Kategori $kategori
    ) {
        return view(
            'kategori.show',
            compact('kategori')
        );
    }

    public function edit(
        Kategori $kategori
    ) {
        return view(
            'kategori.edit',
            compact('kategori')
        );
    }

    public function update(
        Request $request,
        Kategori $kategori
    ) {
        $request->validate([
            'nama_kategori' => 'required',
        ]);
        

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'keterangan' => $request->keterangan,
        ]);

        ActivityHelper::log(
            'Update Kategori',
            'Mengubah kategori ' .
            $kategori->nama_kategori
        );

        return redirect()
            ->route('kategori.index')
            ->with(
                'success',
                'Kategori berhasil diupdate'
            );
    }

    public function destroy(
        Kategori $kategori
    ) {
        ActivityHelper::log(
            'Hapus Kategori',
            'Menghapus kategori ' .
            $kategori->nama_kategori
        );

        $kategori->delete();

        return redirect()
            ->route('kategori.index')
            ->with(
                'success',
                'Kategori berhasil dihapus'
            );
    }
}