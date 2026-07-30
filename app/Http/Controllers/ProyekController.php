<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification as ProyekNotification;
use App\Helpers\ActivityHelper;

class ProyekController extends Controller
{
    public function index()
    {
        $proyek = Proyek::latest()
            ->paginate(10);

        return view(
            'proyek.index',
            compact('proyek')
        );
    }

    public function create()
    {
        return view(
            'proyek.create'
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'kode_proyek' =>
                'required|unique:proyeks,kode_proyek',

            'nama_proyek' =>
                'required|string|max:255',

            'lokasi' =>
                'required|string|max:255',

            'tanggal_mulai' =>
                'required|date',

            'tanggal_selesai' =>
                'nullable|date|after_or_equal:tanggal_mulai',

            'status' =>
                'required'

        ]);

        $proyek = Proyek::create([

            'kode_proyek' =>
                $request->kode_proyek,

            'nama_proyek' =>
                $request->nama_proyek,

            'lokasi' =>
                $request->lokasi,

            'tanggal_mulai' =>
                $request->tanggal_mulai,

            'tanggal_selesai' =>
                $request->tanggal_selesai,

            'status' =>
                $request->status

        ]);

        ActivityHelper::log(
            'Tambah Proyek',
            'Menambahkan proyek ' .
            $proyek->nama_proyek
        );

        ProyekNotification::create([

            'user_id' =>
                Auth::id(),

            'judul' =>
                'Proyek Baru',

            'pesan' =>
                'Proyek ' .
                $proyek->nama_proyek .
                ' berhasil ditambahkan'

        ]);

        return redirect()
            ->route('proyek.index')
            ->with(
                'success',
                'Proyek berhasil ditambahkan'
            );
    }

    public function show(
        Proyek $proyek
    ) {
        return view(
            'proyek.show',
            compact('proyek')
        );
    }

    public function edit(
        Proyek $proyek
    ) {
        return view(
            'proyek.edit',
            compact('proyek')
        );
    }

    public function update(
        Request $request,
        Proyek $proyek
    ) {

        $request->validate([

            'kode_proyek' =>
                'required|unique:proyeks,kode_proyek,' .
                $proyek->id,

            'nama_proyek' =>
                'required|string|max:255',

            'lokasi' =>
                'required|string|max:255',

            'tanggal_mulai' =>
                'required|date',

            'tanggal_selesai' =>
                'nullable|date|after_or_equal:tanggal_mulai',

            'status' =>
                'required'

        ]);

        $proyek->update([

            'kode_proyek' =>
                $request->kode_proyek,

            'nama_proyek' =>
                $request->nama_proyek,

            'lokasi' =>
                $request->lokasi,

            'tanggal_mulai' =>
                $request->tanggal_mulai,

            'tanggal_selesai' =>
                $request->tanggal_selesai,

            'status' =>
                $request->status

        ]);

        ActivityHelper::log(
            'Update Proyek',
            'Mengubah proyek ' .
            $proyek->nama_proyek
        );

        ProyekNotification::create([

            'user_id' =>
                Auth::id(),

            'judul' =>
                'Update Proyek',

            'pesan' =>
                'Proyek ' .
                $proyek->nama_proyek .
                ' berhasil diperbarui'

        ]);

        return redirect()
            ->route('proyek.index')
            ->with(
                'success',
                'Proyek berhasil diperbarui'
            );
    }

    public function destroy(
        Proyek $proyek
    ) {

        try {

            $namaProyek =
                $proyek->nama_proyek;

            ActivityHelper::log(
                'Hapus Proyek',
                'Menghapus proyek ' .
                $namaProyek
            );

            ProyekNotification::create([

                'user_id' =>
                    Auth::id(),

                'judul' =>
                    'Hapus Proyek',

                'pesan' =>
                    'Proyek ' .
                    $namaProyek .
                    ' berhasil dihapus'

            ]);

            $proyek->delete();

            return redirect()
                ->route('proyek.index')
                ->with(
                    'success',
                    'Proyek berhasil dihapus'
                );

        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Proyek tidak dapat dihapus karena masih digunakan.'
                );

        }

    }
}