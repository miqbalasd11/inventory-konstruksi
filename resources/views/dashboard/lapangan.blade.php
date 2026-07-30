@extends('layouts.app')

@section('title', 'Dashboard Proyek')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h1 class="fw-bold">Dashboard Proyek</h1>
        <p class="text-muted">
            Akses cepat untuk staff proyek mengelola permintaan material.
        </p>
    </div>

    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Permintaan Menunggu</h6>
                    <h2 class="fw-bold">{{ $pending ?? 0 }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Permintaan Disetujui</h6>
                    <h2 class="fw-bold">{{ $approved ?? 0 }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Total Permintaan</h6>
                    <h2 class="fw-bold">{{ $total ?? 0 }}</h2>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-4">

        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Permintaan Barang</h5>
                    <p class="card-text">
                        Buat dan lihat permintaan barang proyek.
                    </p>
                    <a href="{{ route('permintaan-barang.index') }}"
                        class="btn btn-primary">
                        Kelola Permintaan
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Laporan Permintaan</h5>
                    <p class="card-text">
                        Lihat status seluruh permintaan material.
                    </p>
                    <a href="{{ route('laporan.permintaan') }}"
                        class="btn btn-primary">
                        Buka Laporan
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection