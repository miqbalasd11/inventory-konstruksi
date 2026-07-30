@extends('layouts.app')

@section('title', 'Dashboard Gudang')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2 class="fw-bold">Dashboard Gudang</h2>
        <p class="text-muted">
            Monitoring stok dan transaksi barang
        </p>
    </div>

    <div class="row">

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Total Barang</h6>
                    <h2 class="fw-bold">{{ $totalBarang ?? 0 }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Stok Tersedia</h6>
                    <h2 class="fw-bold text-success">{{ $totalStok ?? 0 }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Barang Masuk</h6>
                    <h2 class="fw-bold text-primary">{{ $barangMasuk ?? 0 }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Barang Keluar</h6>
                    <h2 class="fw-bold text-danger">{{ $barangKeluar ?? 0 }}</h2>
                </div>
            </div>
        </div>

    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header">
            Transaksi Terbaru
        </div>

        <div class="card-body">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Barang</th>
                        <th>Jenis</th>
                        <th>Qty</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($transaksiTerbaru ?? [] as $item)
                        <tr>
                            <td>{{ $item->created_at->format('d/m/Y') }}</td>
                            <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                            <td>{{ $item->jenis }}</td>
                            <td>{{ $item->qty }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">
                                Belum ada transaksi
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

</div>
@endsection