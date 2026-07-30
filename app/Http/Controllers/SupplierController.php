<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Helpers\ActivityHelper;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    public function index()
    {
        $supplier = Supplier::latest()->get();

        return view('supplier.index', compact('supplier'));
    }

    public function create()
    {
        return view('supplier.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_supplier' => 'required|unique:suppliers',
            'nama_supplier' => 'required',
        ]);

        Supplier::create($request->all());

        ActivityHelper::log(
            'Tambah Supplier',
            'Menambahkan supplier ' .
                $request->nama_supplier
        );
        Notification::create([
            'user_id' => Auth::id(),
            'judul' => 'Supplier Baru',
            'pesan' =>
            'Supplier ' .
                $request->nama_supplier .
                ' berhasil ditambahkan'
        ]);

        return redirect()
            ->route('supplier.index')
            ->with('success', 'Supplier berhasil ditambahkan');
    }

    public function edit(Supplier $supplier)
    {
        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'kode_supplier' => 'required|unique:suppliers,kode_supplier,' . $supplier->id,
            'nama_supplier' => 'required',
        ]);

        $supplier->update($request->all());

        ActivityHelper::log(
            'Update Supplier',
            'Mengupdate supplier ' . $supplier->nama_supplier
        );

        Notification::create([
            'user_id' => Auth::id(),
            'judul' => 'Supplier Diupdate',
            'pesan' => 'Supplier ' . $supplier->nama_supplier . ' berhasil diupdate'
        ]);

        return redirect()
            ->route('supplier.index')
            ->with('success', 'Supplier berhasil diupdate');
    }

    public function destroy(Supplier $supplier)
    {
        $namaSupplier = $supplier->nama_supplier;

        ActivityHelper::log(
            'Hapus Supplier',
            'Menghapus supplier ' . $namaSupplier
        );

        Notification::create([
            'user_id' => Auth::id(),
            'judul' => 'Hapus Supplier',
            'pesan' => 'Supplier ' . $namaSupplier . ' berhasil dihapus'
        ]);

        $supplier->delete();

        return redirect()
            ->route('supplier.index')
            ->with('success', 'Supplier berhasil dihapus');
    }
}
