<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Supplier;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\MaterialRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $purchaseOrders = PurchaseOrder::with([
            'supplier',
            'materialRequest',
            'user'
        ])
            ->latest()
            ->paginate(10);

        return view(
            'purchase_orders.index',
            compact('purchaseOrders')
        );
    }

    public function create()
    {
        $materialRequests = MaterialRequest::with(
            'details.barang'
        )
            ->where('status', 'approved')
            ->get();

        $suppliers = Supplier::all();

        return view(
            'purchase_orders.create',
            compact(
                'materialRequests',
                'suppliers'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'material_request_id' =>
            'required|exists:material_requests,id',

            'supplier_nama' =>
            'required|string|max:255',

            'tanggal_po' =>
            'required|date',

        ]);

        DB::transaction(function () use ($request) {

            $mr = MaterialRequest::with([
                'details.barang'
            ])->findOrFail(
                $request->material_request_id
            );

            /*
        |--------------------------------------------------------------------------
        | SUPPLIER
        |--------------------------------------------------------------------------
        */

            $supplier = Supplier::firstOrCreate(

                [
                    'nama_supplier' => trim($request->supplier_nama)
                ],

                [
                    'kode_supplier' => 'SUP-' . date('YmdHis'),
                    'alamat'        => '-',
                    'telepon'       => '-',
                    'email'         => null,
                ]

            );

            /*
        |--------------------------------------------------------------------------
        | PURCHASE ORDER
        |--------------------------------------------------------------------------
        */

            $po = PurchaseOrder::create([

                'material_request_id' =>
                $mr->id,

                'nomor_po' =>
                'PO-' . time(),

                'supplier_id' =>
                $supplier->id,

                'user_id' =>
                Auth::id(),

                'tanggal_po' =>
                $request->tanggal_po,

                'status' =>
                'Draft',

                'total' =>
                0,

            ]);

            $total = 0;

            /*
        |--------------------------------------------------------------------------
        | DETAIL PO
        |--------------------------------------------------------------------------
        */

            foreach ($mr->details as $detail) {

                $harga =
                    $request->harga[$detail->barang_id]
                    ?? 0;

                $subtotal =
                    $detail->qty * $harga;

                PurchaseOrderDetail::create([

                    'purchase_order_id' =>
                    $po->id,

                    'barang_id' =>
                    $detail->barang_id,

                    'qty' =>
                    $detail->qty,

                    'harga' =>
                    $harga,

                    'subtotal' =>
                    $subtotal,

                ]);

                $total += $subtotal;
            }

            /*
        |--------------------------------------------------------------------------
        | UPDATE TOTAL
        |--------------------------------------------------------------------------
        */

            $po->update([
                'total' => $total
            ]);

            /*
        |--------------------------------------------------------------------------
        | UPDATE STATUS MR
        |--------------------------------------------------------------------------
        */

            $mr->update([
                'status' => 'processed'
            ]);
        });

        return redirect()
            ->route('purchase-orders.index')
            ->with(
                'success',
                'Purchase Order berhasil dibuat'
            );
    }

    public function show(
        PurchaseOrder $purchaseOrder
    ) {
        $purchaseOrder->load([
            'supplier',
            'materialRequest',
            'details.barang'
        ]);

        return view(
            'purchase_orders.show',
            compact('purchaseOrder')
        );
    }

    public function edit(
        PurchaseOrder $purchaseOrder
    ) {
        $suppliers = Supplier::all();

        return view(
            'purchase_orders.edit',
            compact(
                'purchaseOrder',
                'suppliers'
            )
        );
    }

    public function update(
        Request $request,
        PurchaseOrder $purchaseOrder
    ) {
        $purchaseOrder->update([

            'supplier_id' =>
            $request->supplier_id,

            'tanggal_po' =>
            $request->tanggal_po,

            'status' =>
            $request->status,

            'keterangan' =>
            $request->keterangan,
        ]);

        return redirect()
            ->route('purchase-orders.index')
            ->with(
                'success',
                'Purchase Order berhasil diperbarui'
            );
    }

    public function destroy(
        PurchaseOrder $purchaseOrder
    ) {
        $purchaseOrder->delete();

        return redirect()
            ->route('purchase-orders.index')
            ->with(
                'success',
                'Purchase Order berhasil dihapus'
            );
    }

    public function createFromMR(MaterialRequest $mr)
    {
        $mr->load('details.barang');

        $suppliers = Supplier::all();

        return view(
            'purchase_orders.create',
            compact('mr', 'suppliers')
        );
    }

    public function kirim(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->update([
            'status' => 'Dipesan'
        ]);

        return redirect()
            ->back()
            ->with(
                'success',
                'PO berhasil dikirim'
            );
    }
}
