@extends('layouts.app')

@section('title','Detail Proyek')

@section('content')

<div class="container-fluid">

<div class="mb-4">
    <h2 class="fw-bold">
        Detail Proyek
    </h2>
</div>

<div class="card shadow border-0 rounded-4">

    <div class="card-header bg-info text-white">
        <h5 class="mb-0">
            Informasi Proyek
        </h5>
    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <tr>
                <th width="250">
                    Kode Proyek
                </th>
                <td>
                    {{ $proyek->kode_proyek }}
                </td>
            </tr>

            <tr>
                <th>Nama Proyek</th>
                <td>{{ $proyek->nama_proyek }}</td>
            </tr>

            <tr>
                <th>Lokasi</th>
                <td>{{ $proyek->lokasi }}</td>
            </tr>

            <tr>
                <th>Tanggal Mulai</th>
                <td>{{ $proyek->tanggal_mulai }}</td>
            </tr>

            <tr>
                <th>Tanggal Selesai</th>
                <td>{{ $proyek->tanggal_selesai }}</td>
            </tr>

            <tr>
                <th>Status</th>
                <td>

                    @if($proyek->status=='Aktif')
                        <span class="badge bg-success">
                            Aktif
                        </span>
                    @elseif($proyek->status=='Pending')
                        <span class="badge bg-warning">
                            Pending
                        </span>
                    @else
                        <span class="badge bg-secondary">
                            Selesai
                        </span>
                    @endif

                </td>
            </tr>

        </table>

        <div class="mt-3 text-end">

            <a href="{{ route('proyek.index') }}"
                class="btn btn-secondary">
                Kembali
            </a>

            <a href="{{ route('proyek.edit',$proyek->id) }}"
                class="btn btn-warning">
                Edit
            </a>

        </div>

    </div>

</div>

</div>
@endsection
