@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2 class="fw-bold">Dashboard Manajer Proyek</h2>
        <p class="text-muted">
            Monitoring dan persetujuan permintaan material proyek
        </p>
    </div>

    <div class="row">

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Menunggu Persetujuan</h6>
                    <h2 class="fw-bold text-warning">
                        {{ $pending ?? 0 }}
                    </h2>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Disetujui</h6>
                    <h2 class="fw-bold text-success">
                        {{ $approved ?? 0 }}
                    </h2>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Ditolak</h6>
                    <h2 class="fw-bold text-danger">
                        {{ $rejected ?? 0 }}
                    </h2>
                </div>
            </div>
        </div>

    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header">
            Permintaan Barang Terbaru
        </div>

        <div class="card-body">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Proyek</th>
                        <th>Pemohon</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($permintaanTerbaru ?? [] as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->created_at->format('d/m/Y') }}</td>
                            <td>{{ $item->proyek->nama_proyek ?? '-' }}</td>
                            <td>{{ $item->user->name ?? '-' }}</td>
                            <td>
                                <span class="badge bg-warning">
                                    {{ $item->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                Belum ada data
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

</div>
@endsection