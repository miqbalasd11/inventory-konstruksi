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
            'kode_kategori' => 'required|unique:kategoris',
            'nama_kategori' => 'required',
        ]);

        $kategori = Kategori::create([
            'kode_kategori' => $request->kode_kategori,
            'nama_kategori' => $request->nama_kategori,
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
            'kode_kategori' =>
                'required|unique:kategoris,kode_kategori,' .
                $kategori->id,

            'nama_kategori' => 'required',
        ]);

        $kategori->update([
            'kode_kategori' => $request->kode_kategori,
            'nama_kategori' => $request->nama_kategori,
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