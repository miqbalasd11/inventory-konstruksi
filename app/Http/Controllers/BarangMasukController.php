<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\Supplier;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barangMasuks = BarangMasuk::with([
            'supplier',
            'purchaseOrder',
            'user',
            'details.barang'
        ])
            ->latest()
            ->paginate(10);

        return view('barang-masuk.index', compact('barangMasuks'));
    }

    public function create()
    {
        $suppliers = Supplier::all();

        $purchaseOrders = PurchaseOrder::where(
            'status',
            'Dipesan'
        )->get();

        $barangs = Barang::orderBy(
            'nama_barang'
        )->get();

        return view(
            'barang-masuk.create',
            compact(
                'suppliers',
                'purchaseOrders',
                'barangs'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'tanggal_masuk'
            => 'required|date',

            'supplier_id'
            => 'nullable|exists:suppliers,id',

            'purchase_order_id'
            => 'nullable|exists:purchase_orders,id',

            'barang_id'
            => 'required|array|min:1',

            'barang_id.*'
            => 'exists:barangs,id',

            'qty'
            => 'required|array|min:1',

            'qty.*'
            => 'integer|min:1',

            'harga_beli'
            => 'required|array|min:1',

            'harga_beli.*'
            => 'numeric|min:0',

        ]);

        DB::transaction(function () use ($request) {

            $barangMasuk = BarangMasuk::create([

                'kode_masuk'
                => 'BM-' . now()->format('YmdHis'),

                'tanggal_masuk'
                => $request->tanggal_masuk,

                'supplier_id'
                => $request->supplier_id,

                'purchase_order_id'
                => $request->purchase_order_id,

                'user_id'
                => Auth::id(),

                'keterangan'
                => $request->keterangan,

            ]);

            foreach (
                $request->barang_id
                as $index => $barangId
            ) {

                $qty =
                    (int) $request->qty[$index];

                $harga =
                    (float) $request->harga_beli[$index];

                $subtotal =
                    $qty * $harga;

                $barangMasuk
                    ->details()
                    ->create([

                        'barang_id'
                        => $barangId,

                        'qty'
                        => $qty,

                        'harga_beli'
                        => $harga,

                        'subtotal'
                        => $subtotal,

                    ]);

                Barang::findOrFail(
                    $barangId
                )->increment(
                    'stok',
                    $qty
                );
            }

            if (
                $request->purchase_order_id
            ) {

                PurchaseOrder::find(
                    $request->purchase_order_id
                )?->update([
                    'status' => 'Diterima'
                ]);
            }
        });

        return redirect()
            ->route('barang-masuk.index')
            ->with(
                'success',
                'Barang masuk berhasil disimpan dan stok diperbarui.'
            );
    }


    public function show(BarangMasuk $barangMasuk)
    {
        $barangMasuk->load([
            'supplier',
            'purchaseOrder',
            'user',
            'details.barang'
        ]);

        return view('barang-masuk.show', compact('barangMasuk'));
    }

    public function destroy(
        BarangMasuk $barangMasuk
    ) {
        DB::transaction(function () use (
            $barangMasuk
        ) {

            foreach (
                $barangMasuk->details
                as $detail
            ) {

                $detail->barang
                    ->decrement(
                        'stok',
                        $detail->qty
                    );
            }

            if (
                $barangMasuk->purchase_order_id
            ) {

                PurchaseOrder::find(
                    $barangMasuk->purchase_order_id
                )?->update([
                    'status' => 'Dipesan'
                ]);
            }

            $barangMasuk->delete();
        });

        return redirect()
            ->route('barang-masuk.index')
            ->with(
                'success',
                'Data barang masuk berhasil dihapus.'
            );
    }

    public function edit(BarangMasuk $barangMasuk)
    {
        $barangMasuk->load('details.barang');

        $suppliers = Supplier::all();

        $barangs = Barang::orderBy('nama_barang')->get();

        return view(
            'barang-masuk.edit',
            compact(
                'barangMasuk',
                'suppliers',
                'barangs'
            )
        );
    }

    public function update(
        Request $request,
        BarangMasuk $barangMasuk
    ) {
        $request->validate([
            'tanggal_masuk' => 'required|date',
            'supplier_id'   => 'nullable|exists:suppliers,id',
            'keterangan'    => 'nullable'
        ]);

        $barangMasuk->update([
            'tanggal_masuk' => $request->tanggal_masuk,
            'supplier_id'   => $request->supplier_id,
            'keterangan'    => $request->keterangan,
        ]);

        return redirect()
            ->route('barang-masuk.index')
            ->with(
                'success',
                'Data Barang Masuk berhasil diperbarui'
            );
    }
}
