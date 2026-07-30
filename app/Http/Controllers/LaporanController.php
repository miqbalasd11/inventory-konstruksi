<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\BarangKeluarDetail;
use App\Models\BarangMasukDetail;
use App\Models\MaterialRequest;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\PermintaanBarang;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Exports\CollectionExport;
use App\Exports\StokBarangExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LAPORAN STOK
    |--------------------------------------------------------------------------
    */

    public function stok()
    {
        $barang = Barang::with([
            'kategori',
            'satuan',
            'supplier',
        ])
            ->orderBy('nama_barang')
            ->get();

        return view(
            'laporan.stok',
            compact('barang')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | LAPORAN BARANG MASUK
    |--------------------------------------------------------------------------
    */

    public function barangMasuk(Request $request)
    {
        $query = BarangMasuk::with([
            'supplier',
            'user',
            'details.barang'
        ]);

        if (
            $request->filled('tanggal_awal') &&
            $request->filled('tanggal_akhir')
        ) {
            $query->whereBetween('tanggal', [
                $request->tanggal_awal,
                $request->tanggal_akhir,
            ]);
        }

        $barangMasuk = $query
            ->latest()
            ->get();

        return view(
            'laporan.barang-masuk',
            compact('barangMasuk')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | LAPORAN BARANG KELUAR
    |--------------------------------------------------------------------------
    */

    public function barangKeluar(Request $request)
    {
        $query = BarangKeluar::with([
            'proyek',
            'user',
            'details.barang'
        ]);

        if (
            $request->filled('tanggal_awal') &&
            $request->filled('tanggal_akhir')
        ) {
            $query->whereBetween(
                'tanggal_keluar',
                [
                    $request->tanggal_awal,
                    $request->tanggal_akhir
                ]
            );
        }

        $barangKeluar = $query
            ->latest()
            ->get();

        return view(
            'laporan.barang-keluar',
            compact('barangKeluar')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | LAPORAN MATERIAL PROYEK
    |--------------------------------------------------------------------------
    */

    public function proyek()
    {
        $laporan = DB::table('barang_keluar_details')
            ->join(
                'barang_keluars',
                'barang_keluar_details.barang_keluar_id',
                '=',
                'barang_keluars.id'
            )
            ->join(
                'barangs',
                'barang_keluar_details.barang_id',
                '=',
                'barangs.id'
            )
            ->join(
                'proyeks',
                'barang_keluars.proyek_id',
                '=',
                'proyeks.id'
            )
            ->select(
                'proyeks.nama_proyek',
                'barangs.nama_barang',
                DB::raw(
                    'SUM(barang_keluar_details.qty) as total_pakai'
                )
            )
            ->groupBy(
                'proyeks.nama_proyek',
                'barangs.nama_barang'
            )
            ->get();

        return view(
            'laporan.proyek',
            compact('laporan')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | LAPORAN PERMINTAAN BARANG
    |--------------------------------------------------------------------------
    */

    public function permintaan(Request $request)
    {
        $query = PermintaanBarang::with([
            'barang',
            'proyek',
            'user',
            'approver',
        ]);

        if (
            $request->filled('tanggal_awal') &&
            $request->filled('tanggal_akhir')
        ) {
            $query->whereBetween('tanggal', [
                $request->tanggal_awal,
                $request->tanggal_akhir,
            ]);
        }

        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }

        $permintaan = $query
            ->latest()
            ->get();

        return view(
            'laporan.permintaan',
            compact('permintaan')
        );
    }

    public function pdfPermintaan(Request $request)
    {
        $query = PermintaanBarang::with([
            'barang',
            'proyek',
            'user',
            'approver',
        ]);

        if (
            $request->filled('tanggal_awal') &&
            $request->filled('tanggal_akhir')
        ) {
            $query->whereBetween('tanggal', [
                $request->tanggal_awal,
                $request->tanggal_akhir,
            ]);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $permintaan = $query->latest()->get();

        $pdf = Pdf::loadView(
            'laporan.pdf.permintaan',
            compact('permintaan')
        );

        return $pdf->stream(
            'laporan-permintaan-barang.pdf'
        );
    }

    public function exportPermintaan(Request $request)
    {
        $query = PermintaanBarang::with([
            'barang',
            'proyek',
            'user',
            'approver',
        ]);

        if (
            $request->filled('tanggal_awal') &&
            $request->filled('tanggal_akhir')
        ) {
            $query->whereBetween('tanggal', [
                $request->tanggal_awal,
                $request->tanggal_akhir,
            ]);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $permintaan = $query->latest()->get();

        $rows = $permintaan->map(function ($item, $index) {
            return [
                $index + 1,
                $item->kode_permintaan,
                $item->tanggal,
                $item->barang->nama_barang ?? '-',
                $item->proyek->nama_proyek ?? '-',
                $item->qty,
                $item->status,
                $item->user->name ?? '-',
                $item->approver->name ?? '-',
                $item->approved_at ?? '-',
            ];
        });

        return Excel::download(
            new CollectionExport(
                collect($rows),
                [
                    'No',
                    'Kode Permintaan',
                    'Tanggal',
                    'Barang',
                    'Proyek',
                    'Qty',
                    'Status',
                    'Pemohon',
                    'Disetujui Oleh',
                    'Tanggal Approval',
                ]
            ),
            'laporan-permintaan.xlsx'
        );
    }

    public function pdfStok(Request $request)
    {
        $barang = Barang::with([
            'kategori',
            'satuan',
            'supplier',
        ])
            ->orderBy('nama_barang')
            ->get();

        $pdf = Pdf::loadView(
            'laporan.pdf.stok',
            compact('barang')
        );

        return $pdf->stream('laporan-stok.pdf');
    }

    public function exportBarangMasuk(Request $request)
    {
        $query = BarangMasuk::with([
            'supplier',
            'user',
            'details.barang'
        ]);

        if (
            $request->filled('tanggal_awal') &&
            $request->filled('tanggal_akhir')
        ) {
            $query->whereBetween(
                'tanggal_masuk',
                [
                    $request->tanggal_awal,
                    $request->tanggal_akhir
                ]
            );
        }

        $barangMasuk = $query->latest()->get();

        $rows = collect();

        foreach ($barangMasuk as $item) {

            foreach ($item->details as $detail) {

                $rows->push([

                    $item->nomor_masuk,

                    $item->tanggal_masuk,

                    optional(
                        $detail->barang
                    )->nama_barang,

                    $detail->qty,

                    $detail->harga_beli,

                    $detail->subtotal,

                    optional(
                        $item->user
                    )->name,

                ]);
            }
        }

        return Excel::download(
            new CollectionExport(
                $rows,
                [
                    'No Masuk',
                    'Tanggal',
                    'Barang',
                    'Qty',
                    'Harga',
                    'Total',
                    'User',
                ]
            ),
            'laporan-barang-masuk.xlsx'
        );
    }

    public function pdfBarangMasuk(Request $request)
    {
        $query = BarangMasuk::with([
            'supplier',
            'user',
            'details.barang'
        ]);

        if (
            $request->filled('tanggal_awal') &&
            $request->filled('tanggal_akhir')
        ) {
            $query->whereBetween(
                'tanggal_masuk',
                [
                    $request->tanggal_awal,
                    $request->tanggal_akhir
                ]
            );
        }

        $barangMasuk = $query->latest()->get();

        $pdf = Pdf::loadView(
            'laporan.pdf.barang-masuk',
            compact('barangMasuk')
        );

        return $pdf->stream(
            'laporan-barang-masuk.pdf'
        );
    }

    public function exportBarangKeluar(Request $request)
    {
        $query = BarangKeluar::with([
            'proyek',
            'user',
            'details.barang'
        ]);

        if (
            $request->filled('tanggal_awal') &&
            $request->filled('tanggal_akhir')
        ) {
            $query->whereBetween(
                'tanggal_keluar',
                [
                    $request->tanggal_awal,
                    $request->tanggal_akhir
                ]
            );
        }

        $barangKeluar = $query
            ->latest()
            ->get();

        $rows = collect();

        foreach ($barangKeluar as $item) {

            foreach ($item->details as $detail) {

                $rows->push([
                    $item->nomor_keluar,
                    $item->tanggal_keluar,
                    optional($item->proyek)->nama_proyek,
                    optional($detail->barang)->nama_barang,
                    $detail->qty,
                    $item->keterangan ?? '-',
                    optional($item->user)->name,
                ]);
            }
        }

        return Excel::download(
            new CollectionExport(
                $rows,
                [
                    'No Keluar',
                    'Tanggal',
                    'Proyek',
                    'Barang',
                    'Qty',
                    'Keterangan',
                    'User',
                ]
            ),
            'laporan-barang-keluar.xlsx'
        );
    }

    public function pdfBarangKeluar(Request $request)
    {
        $query = BarangKeluar::with([
            'proyek',
            'user',
            'details.barang'
        ]);

        if (
            $request->filled('tanggal_awal') &&
            $request->filled('tanggal_akhir')
        ) {
            $query->whereBetween(
                'tanggal_keluar',
                [
                    $request->tanggal_awal,
                    $request->tanggal_akhir
                ]
            );
        }

        $barangKeluar = $query
            ->latest()
            ->get();

        $pdf = Pdf::loadView(
            'laporan.pdf.barang-keluar',
            compact('barangKeluar')
        );

        return $pdf->stream(
            'laporan-barang-keluar.pdf'
        );
    }

    public function exportProyek()
    {
        $laporan = BarangKeluar::select(
            'proyek_id',
            'barang_id',
            DB::raw('SUM(qty) as total_pakai')
        )
            ->with(['proyek', 'barang'])
            ->groupBy('proyek_id', 'barang_id')
            ->orderBy('proyek_id')
            ->get();

        $rows = $laporan->map(function ($item, $index) {
            return [
                $index + 1,
                optional($item->proyek)->nama_proyek,
                optional($item->barang)->nama_barang,
                $item->total_pakai,
            ];
        });

        return Excel::download(
            new CollectionExport(
                collect($rows),
                [
                    'No',
                    'Proyek',
                    'Barang',
                    'Total Pakai',
                ]
            ),
            'laporan-material-proyek.xlsx'
        );
    }

    public function pdfProyek()
    {
        $laporan = BarangKeluar::select(
            'proyek_id',
            'barang_id',
            DB::raw('SUM(qty) as total_pakai')
        )
            ->with(['proyek', 'barang'])
            ->groupBy('proyek_id', 'barang_id')
            ->orderBy('proyek_id')
            ->get();

        $pdf = Pdf::loadView(
            'laporan.pdf.proyek',
            compact('laporan')
        );

        return $pdf->stream('laporan-material-proyek.pdf');
    }

    public function exportKartuStok(Request $request)
    {
        $barang = Barang::all();
        $transaksi = collect();
        $barangDipilih = null;

        if ($request->barang_id) {
            $barangDipilih = Barang::find($request->barang_id);

            $masuk = BarangMasukDetail::with('barangMasuk')
                ->get()
                ->map(function ($item) {
                    return [
                        'tanggal' => $item->tanggal,
                        'referensi' => $item->kode_masuk,
                        'jenis' => 'Masuk',
                        'masuk' => $item->qty,
                        'keluar' => 0,
                    ];
                });

            $keluar = BarangKeluarDetail::where('barang_id', $request->barang_id)
                ->get()
                ->map(function ($item) {
                    return [
                        'tanggal' => $item->tanggal,
                        'referensi' => $item->kode_keluar,
                        'jenis' => 'Keluar',
                        'masuk' => 0,
                        'keluar' => $item->qty,
                    ];
                });

            $transaksi = $masuk->merge($keluar)
                ->sortBy('tanggal')
                ->values();
        }

        $rows = $transaksi->map(function ($item, $index) {
            return [
                $index + 1,
                $item['tanggal'],
                $item['referensi'],
                $item['jenis'],
                $item['masuk'],
                $item['keluar'],
            ];
        });

        return Excel::download(
            new CollectionExport(
                collect($rows),
                [
                    'No',
                    'Tanggal',
                    'Referensi',
                    'Jenis',
                    'Masuk',
                    'Keluar',
                ]
            ),
            'laporan-kartu-stok.xlsx'
        );
    }

    public function pdfKartuStok(Request $request)
    {
        $barang = Barang::all();
        $transaksi = collect();
        $barangDipilih = null;

        if ($request->barang_id) {
            $barangDipilih = Barang::find($request->barang_id);

            $masuk = BarangMasukDetail::where('barang_id', $request->barang_id)
                ->get()
                ->map(function ($item) {
                    return [
                        'tanggal' => $item->tanggal,
                        'referensi' => $item->kode_masuk,
                        'jenis' => 'Masuk',
                        'masuk' => $item->qty,
                        'keluar' => 0,
                    ];
                });

            $keluar = BarangKeluar::where('barang_id', $request->barang_id)
                ->get()
                ->map(function ($item) {
                    return [
                        'tanggal' => $item->tanggal,
                        'referensi' => $item->kode_keluar,
                        'jenis' => 'Keluar',
                        'masuk' => 0,
                        'keluar' => $item->qty,
                    ];
                });

            $transaksi = $masuk->merge($keluar)
                ->sortBy('tanggal')
                ->values();
        }

        $pdf = Pdf::loadView(
            'laporan.pdf.kartu-stok',
            compact('barangDipilih', 'transaksi')
        );

        return $pdf->stream('laporan-kartu-stok.pdf');
    }

    public function kartuStok(Request $request)
    {
        $barang = Barang::all();

        $transaksi = collect();

        $barangDipilih = null;

        if ($request->barang_id) {

            $barangDipilih = Barang::findOrFail(
                $request->barang_id
            );

            $masuk = BarangMasukDetail::with(
                'barangMasuk'
            )
                ->where(
                    'barang_id',
                    $request->barang_id
                )
                ->get()
                ->map(function ($item) {

                    return [

                        'tanggal' =>
                        $item->barangMasuk->tanggal_masuk,

                        'jenis' =>
                        'Masuk',

                        'qty_masuk' =>
                        $item->qty,

                        'qty_keluar' =>
                        0,

                        'referensi' =>
                        $item->barangMasuk->nomor_masuk

                    ];
                });

            $keluar = BarangKeluarDetail::with(
                'barangKeluar'
            )
                ->where(
                    'barang_id',
                    $request->barang_id
                )
                ->get()
                ->map(function ($item) {

                    return [

                        'tanggal' =>
                        $item->barangKeluar->tanggal_keluar,

                        'jenis' =>
                        'Keluar',

                        'qty_masuk' =>
                        0,

                        'qty_keluar' =>
                        $item->qty,

                        'referensi' =>
                        $item->barangKeluar->nomor_keluar

                    ];
                });

            $transaksi = $masuk
                ->merge($keluar)
                ->sortBy('tanggal')
                ->values();
        }

        return view(
            'laporan.kartu-stok',
            compact(
                'barang',
                'barangDipilih',
                'transaksi'
            )
        );
    }

    public function exportStok()
    {
        return Excel::download(
            new StokBarangExport,
            'laporan-stok.xlsx'
        );
    }

    public function exportPdf()
    {
        $barang = Barang::with(['kategori', 'satuan', 'supplier'])->get();
        $pdf = Pdf::loadView('laporan.stok_pdf', compact('barang'))->setPaper('a4', 'landscape');

        return $pdf->download('laporan_stok_barang.pdf');
    }
    public function materialRequest(Request $request)
{
    $query = MaterialRequest::with([
        'user',
        'details.barang'
    ]);

    if ($request->filled('status')) {

        $query->where(
            'status',
            $request->status
        );
    }

    $materialRequests = $query
        ->latest()
        ->get();

    return view(
        'laporan.material-request',
        compact('materialRequests')
    );
}
public function pdfMaterialRequest(Request $request)
{
    $query = MaterialRequest::with([
        'user',
        'details.barang'
    ]);

    if ($request->filled('status')) {

        $query->where(
            'status',
            $request->status
        );
    }

    $materialRequests = $query
        ->latest()
        ->get();

    $pdf = Pdf::loadView(
        'laporan.pdf.material-request',
        compact('materialRequests')
    );

    return $pdf->stream(
        'laporan-material-request.pdf'
    );
}
public function exportMaterialRequest(Request $request)
{
    $query = MaterialRequest::with([
        'user',
        'details.barang'
    ]);

    if ($request->filled('status')) {

        $query->where(
            'status',
            $request->status
        );
    }

    $materialRequests = $query
        ->latest()
        ->get();

    $rows = collect();

    foreach ($materialRequests as $mr) {

        foreach ($mr->details as $detail) {

            $rows->push([

                $mr->nomor_mr,

                $mr->tanggal_request,

                $detail->barang->nama_barang ?? '-',

                $detail->qty,

                $mr->status,

                $mr->user->name ?? '-'

            ]);
        }
    }

    return Excel::download(

        new CollectionExport(

            $rows,

            [
                'Nomor MR',
                'Tanggal',
                'Barang',
                'Qty',
                'Status',
                'User'
            ]
        ),

        'laporan-material-request.xlsx'
    );
}
public function purchaseOrder(Request $request)
{
    $query = PurchaseOrder::with([
        'supplier',
        'user',
        'materialRequest'
    ]);

    if (
        $request->filled('tanggal_awal') &&
        $request->filled('tanggal_akhir')
    ) {

        $query->whereBetween(
            'tanggal_po',
            [
                $request->tanggal_awal,
                $request->tanggal_akhir
            ]
        );
    }

    $purchaseOrders = $query
        ->latest()
        ->get();

    return view(
        'laporan.purchase-order',
        compact('purchaseOrders')
    );
}
public function pdfPurchaseOrder(Request $request)
{
    $query = PurchaseOrder::with([
        'supplier',
        'user',
        'materialRequest'
    ]);

    if (
        $request->filled('tanggal_awal') &&
        $request->filled('tanggal_akhir')
    ) {

        $query->whereBetween(
            'tanggal_po',
            [
                $request->tanggal_awal,
                $request->tanggal_akhir
            ]
        );
    }

    $purchaseOrders = $query
        ->latest()
        ->get();

    $pdf = Pdf::loadView(
        'laporan.pdf.purchase-order',
        compact('purchaseOrders')
    );

    return $pdf->stream(
        'laporan-purchase-order.pdf'
    );
}
public function exportPurchaseOrder(Request $request)
{
    $query = PurchaseOrder::with([
        'supplier',
        'user',
        'materialRequest'
    ]);

    if (
        $request->filled('tanggal_awal') &&
        $request->filled('tanggal_akhir')
    ) {

        $query->whereBetween(
            'tanggal_po',
            [
                $request->tanggal_awal,
                $request->tanggal_akhir
            ]
        );
    }

    $purchaseOrders = $query
        ->latest()
        ->get();

    $rows = $purchaseOrders->map(
        function ($item) {

            return [

                $item->nomor_po,

                $item->materialRequest->nomor_mr ?? '-',

                $item->supplier->nama_supplier ?? '-',

                $item->tanggal_po,

                $item->status,

                $item->total

            ];
        }
    );

    return Excel::download(

        new CollectionExport(

            $rows,

            [

                'Nomor PO',
                'Nomor MR',
                'Supplier',
                'Tanggal PO',
                'Status',
                'Total'

            ]
        ),

        'laporan-purchase-order.xlsx'
    );
}
public function supplier()
{
    $suppliers = Supplier::latest()->paginate(10);

    return view('laporan.supplier', compact('suppliers'));
}

public function pdfSupplier(Request $request)
{
    $query = Supplier::query();

    if ($request->filled('nama_supplier')) {
        $query->where(
            'nama_supplier',
            'like',
            '%' . $request->nama_supplier . '%'
        );
    }

    $suppliers = $query
        ->latest()
        ->get();

    $pdf = Pdf::loadView(
        'laporan.pdf.supplier',
        compact('suppliers')
    );

    return $pdf->stream(
        'laporan-supplier.pdf'
    );
}

public function exportSupplier(Request $request)
{
    $query = Supplier::query();

    if ($request->filled('nama_supplier')) {
        $query->where(
            'nama_supplier',
            'like',
            '%' . $request->nama_supplier . '%'
        );
    }

    $suppliers = $query
        ->latest()
        ->get();

    $rows = $suppliers->map(
        function ($item) {

            return [

                $item->kode_supplier,

                $item->nama_supplier,

                $item->telepon,

                $item->email,

                $item->alamat

            ];
        }
    );

    return Excel::download(

        new CollectionExport(

            $rows,

            [

                'Kode Supplier',
                'Nama Supplier',
                'Telepon',
                'Email',
                'Alamat'

            ]
        ),

        'laporan-supplier.xlsx'
    );
}
}
