<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\Proyek;
use App\Models\MaterialRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Helpers\ActivityHelper;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $barangKeluars = BarangKeluar::with([
            'proyek',
            'materialRequest',
            'user',
            'details.barang'
        ])
        ->latest()
        ->paginate(10);

        return view(
            'barang-keluar.index',
            compact('barangKeluars')
        );
    }

    public function create()
    {
        $barangs = Barang::orderBy(
            'nama_barang'
        )->get();

        $proyeks = Proyek::orderBy(
            'nama_proyek'
        )->get();

        $materialRequests =
            MaterialRequest::whereIn(
                'status',
                [
                    'approved',
                    'processed'
                ]
            )->get();

        return view(
            'barang-keluar.create',
            compact(
                'barangs',
                'proyeks',
                'materialRequests'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'tanggal_keluar'
                => 'required|date',

            'proyek_id'
                => 'required|exists:proyeks,id',

            'barang_id'
                => 'required|array|min:1',

            'barang_id.*'
                => 'exists:barangs,id',

            'qty'
                => 'required|array|min:1',

            'qty.*'
                => 'integer|min:1',

        ]);

        DB::transaction(function () use (
            $request
        ) {

            foreach (
                $request->barang_id
                as $index => $barangId
            ) {

                $barang =
                    Barang::findOrFail(
                        $barangId
                    );

                $qty =
                    (int) $request->qty[$index];

                if (
                    $qty > $barang->stok
                ) {

                    throw ValidationException::withMessages([

                        'stok' =>
                        'Stok ' .
                        $barang->nama_barang .
                        ' tidak mencukupi.'

                    ]);
                }
            }

            $nomorKeluar =
                'BK-' .
                now()->format(
                    'YmdHis'
                );

            $barangKeluar =
                BarangKeluar::create([

                    'nomor_keluar'
                        => $nomorKeluar,

                    'tanggal_keluar'
                        => $request->tanggal_keluar,

                    'proyek_id'
                        => $request->proyek_id,

                    'material_request_id'
                        => $request->material_request_id,

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

                $barangKeluar
                    ->details()
                    ->create([

                        'barang_id'
                            => $barangId,

                        'qty'
                            => $qty,

                    ]);

                Barang::findOrFail(
                    $barangId
                )->decrement(
                    'stok',
                    $qty
                );
            }

            if (
                $request->material_request_id
            ) {

                MaterialRequest::find(
                    $request->material_request_id
                )?->update([
                    'status' => 'completed'
                ]);
            }

            ActivityHelper::log(
                'Barang Keluar',
                'Transaksi ' .
                $nomorKeluar .
                ' berhasil dibuat'
            );
        });

        return redirect()
            ->route(
                'barang-keluar.index'
            )
            ->with(
                'success',
                'Barang keluar berhasil disimpan.'
            );
    }

    public function show(
        BarangKeluar $barangKeluar
    ) {
        $barangKeluar->load([
            'proyek',
            'materialRequest',
            'user',
            'details.barang'
        ]);

        return view(
            'barang-keluar.show',
            compact(
                'barangKeluar'
            )
        );
    }

    public function destroy(
        BarangKeluar $barangKeluar
    ) {
        DB::transaction(function () use (
            $barangKeluar
        ) {

            foreach (
                $barangKeluar->details
                as $detail
            ) {

                $detail->barang
                    ->increment(
                        'stok',
                        $detail->qty
                    );
            }

            if (
                $barangKeluar->material_request_id
            ) {

                MaterialRequest::find(
                    $barangKeluar->material_request_id
                )?->update([
                    'status' => 'approved'
                ]);
            }

            ActivityHelper::log(
                'Hapus Barang Keluar',
                'Menghapus transaksi ' .
                $barangKeluar->nomor_keluar
            );

            $barangKeluar->delete();
        });

        return redirect()
            ->route(
                'barang-keluar.index'
            )
            ->with(
                'success',
                'Barang keluar berhasil dihapus.'
            );
    }
}