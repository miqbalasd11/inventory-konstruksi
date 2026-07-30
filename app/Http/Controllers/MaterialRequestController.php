<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\MaterialRequest;
use App\Models\MaterialRequestDetail;
use App\Http\Requests\StoreMaterialRequestRequest;

class MaterialRequestController extends Controller
{
    public function index()
    {
        $requests = MaterialRequest::with([
            'user',
            'details.barang',
            'details.kategori'
        ])
            ->latest()
            ->paginate(10);

        return view(
            'material_request.index',
            compact('requests')
        );
    }

    public function create()
    {
        $barangs = Barang::all();
        $kategoris = Kategori::all();

        return view(
            'material_request.create',
            compact(
                'barangs',
                'kategoris'
            )
        );
    }

    public function store(StoreMaterialRequestRequest $request)
{
    DB::transaction(function () use ($request) {

        /*
        |--------------------------------------------------------------------------
        | HEADER MR
        |--------------------------------------------------------------------------
        */

        $mr = MaterialRequest::create([

            'nomor_mr' => 'MR-' .
                now()->format('YmdHis'),

            'user_id' => Auth::id(),

            'tanggal_request' => now(),

            'status' => 'pending',

            'keterangan' => $request->keterangan,

        ]);

        /*
        |--------------------------------------------------------------------------
        | DETAIL MR
        |--------------------------------------------------------------------------
        */

        foreach ($request->nama_barang as $index => $namaBarang) {

            /*
            |--------------------------------------------------------------------------
            | KATEGORI
            |--------------------------------------------------------------------------
            */

            $namaKategori =
                $request->nama_kategori[$index] ?? 'Lainnya';

            $kategori = Kategori::firstOrCreate(

                [
                    'nama_kategori' => trim($namaKategori)
                ],

                [
                    'kode_kategori' =>
                    'KTG-' . time() . rand(100,999)
                ]

            );

            /*
            |--------------------------------------------------------------------------
            | BARANG
            |--------------------------------------------------------------------------
            */

            $barang = Barang::firstOrCreate(

                [
                    'nama_barang' =>
                    trim($namaBarang)
                ],

                [

                    'kode_barang' =>
                    'BRG-' . time() . rand(100,999),

                    'kategori_id' =>
                    $kategori->id,

                    'satuan_id' => 1,

                    'supplier_id' => 1,

                    'stok' => 0,

                    'stok_minimum' => 0,

                    'harga_beli' => 0,

                    'keterangan' => null,

                ]

            );

            /*
            |--------------------------------------------------------------------------
            | DETAIL
            |--------------------------------------------------------------------------
            */

            MaterialRequestDetail::create([

                'material_request_id' =>
                $mr->id,

                'barang_id' =>
                $barang->id,

                'kategori_id' =>
                $kategori->id,

                'qty' =>
                $request->qty[$index],

                'catatan' =>
                $request->catatan[$index] ?? null,

            ]);
        }
    });

    return redirect()
        ->route('material-request.index')
        ->with(
            'success',
            'Material Request berhasil dibuat'
        );
}

    public function show(MaterialRequest $materialRequest)
    {
        $materialRequest->load([
            'user',
            'details.barang',
            'details.kategori'
        ]);

        return view(
            'material_request.show',
            compact('materialRequest')
        );
    }
}
