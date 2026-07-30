<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Helpers\ActivityHelper;
use Illuminate\Support\Facades\Auth;

class SatuanController extends Controller
{
    public function index()
    {
        $satuan = Satuan::latest()->get();

        return view('satuan.index', compact('satuan'));
    }

    public function create()
    {
        return view('satuan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_satuan' => 'required|unique:satuans',
            'nama_satuan' => 'required',
        ]);

        $satuan = Satuan::create($request->all());

        ActivityHelper::log(
            'Tambah Satuan',
            'Menambahkan satuan ' .
                $satuan->nama_satuan
        );

        Notification::create([
            'user_id' => Auth::id(),
            'judul' => 'Satuan Baru',
            'pesan' =>
            'Satuan ' .
                $satuan->nama_satuan .
                ' berhasil ditambahkan'
        ]);

        return redirect()
            ->route('satuan.index')
            ->with('success', 'Data satuan berhasil ditambahkan');
    }

    public function edit(Satuan $satuan)
    {
        return view('satuan.edit', compact('satuan'));
    }

    public function update(Request $request, Satuan $satuan)
    {
        $request->validate([
            'kode_satuan' => 'required|unique:satuans,kode_satuan,' . $satuan->id,
            'nama_satuan' => 'required',
        ]);

        $satuan->update($request->all());

        ActivityHelper::log(
            'Update Satuan',
            'Mengubah satuan ' .
                $satuan->nama_satuan
        );

        Notification::create([
            'user_id' => Auth::id(),
            'judul' => 'Update Satuan',
            'pesan' =>
            'Satuan ' .
                $satuan->nama_satuan .
                ' berhasil diperbarui'
        ]);

        return redirect()
            ->route('satuan.index')
            ->with('success', 'Data satuan berhasil diupdate');
    }

    public function destroy(Satuan $satuan)
    {
        $namaSatuan = $satuan->nama_satuan;

        ActivityHelper::log(
            'Hapus Satuan',
            'Menghapus satuan ' .
                $namaSatuan
        );

        Notification::create([
            'user_id' => Auth::id(),
            'judul' => 'Hapus Satuan',
            'pesan' =>
            'Satuan ' .
                $namaSatuan .
                ' berhasil dihapus'
        ]);
        $satuan->delete();

        return redirect()
            ->route('satuan.index')
            ->with('success', 'Data satuan berhasil dihapus');
    }
}
