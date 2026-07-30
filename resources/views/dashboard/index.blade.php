@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="card border-0 shadow-sm mb-4"
        style="background: linear-gradient(135deg,#0d6efd,#6610f2);">

        <div class="card-body text-white p-4">

            <h2 class="fw-bold mb-2">
                Inventory Konstruksi Dashboard
            </h2>

            <p class="mb-0 opacity-75">
                Monitoring persediaan material proyek secara real-time
            </p>

        </div>

    </div>

    {{-- KPI --}}
    <div class="row g-4 mb-4">

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>
                            <small class="text-muted">
                                TOTAL BARANG
                            </small>

                            <h2 class="fw-bold mt-2">
                                {{ number_format($totalBarang) }}
                            </h2>
                        </div>

                        <i class="bi bi-box-seam fs-1 text-primary"></i>

                    </div>

                </div>

            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>
                            <small class="text-muted">
                                SUPPLIER
                            </small>

                            <h2 class="fw-bold mt-2">
                                {{ number_format($totalSupplier) }}
                            </h2>
                        </div>

                        <i class="bi bi-truck fs-1 text-success"></i>

                    </div>

                </div>

            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>
                            <small class="text-muted">
                                PROYEK
                            </small>

                            <h2 class="fw-bold mt-2">
                                {{ number_format($totalProyek) }}
                            </h2>
                        </div>

                        <i class="bi bi-building fs-1 text-info"></i>

                    </div>

                </div>

            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>
                            <small class="text-muted">
                                USER
                            </small>

                            <h2 class="fw-bold mt-2">
                                {{ number_format($totalUser) }}
                            </h2>
                        </div>

                        <i class="bi bi-people fs-1 text-warning"></i>

                    </div>

                </div>

            </div>
        </div>

    </div>

    {{-- KPI 2 --}}
    <div class="row g-4 mb-4">

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">

                    <small class="text-muted">
                        BARANG MASUK
                    </small>

                    <h3 class="fw-bold text-success">
                        {{ number_format($totalBarangMasuk) }}
                    </h3>

                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">

                    <small class="text-muted">
                        BARANG KELUAR
                    </small>

                    <h3 class="fw-bold text-danger">
                        {{ number_format($totalBarangKeluar) }}
                    </h3>

                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">

                    <small class="text-muted">
                        STOK MENIPIS
                    </small>

                    <h3 class="fw-bold text-warning">
                        {{ $stokMenipis }}
                    </h3>

                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">

                    <small class="text-muted">
                        NILAI PERSEDIAAN
                    </small>

                    <h5 class="fw-bold text-primary">
                        Rp {{ number_format($totalNilaiPersediaan,0,',','.') }}
                    </h5>

                </div>
            </div>
        </div>

    </div>

    <div class="row g-4 mb-4">

        <div class="col-md-6">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Permintaan Menunggu
                            </small>

                            <h2 class="fw-bold text-warning mt-2">
                                {{ $permintaanPending }}
                            </h2>

                        </div>

                        <i class="bi bi-hourglass-split fs-1 text-warning"></i>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-6">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Permintaan Disetujui
                            </small>

                            <h2 class="fw-bold text-success mt-2">
                                {{ $permintaanDisetujui }}
                            </h2>

                        </div>

                        <i class="bi bi-check-circle fs-1 text-success"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- GRAFIK --}}
    <div class="row g-4 mb-4">

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold">
                        Grafik Pergerakan Material
                    </h5>
                </div>

                <div class="card-body">

                    <canvas
                        id="inventoryChart"
                        height="120"
                        data-masuk='@json($grafikMasuk)'
                        data-keluar='@json($grafikKeluar)'>
                    </canvas>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold">
                        Ringkasan Proyek
                    </h5>
                </div>

                <div class="card-body">

                    <div class="mb-4">

                        <h3 class="fw-bold text-primary">
                            {{ $proyekAktif }}
                        </h3>

                        <small class="text-muted">
                            Proyek Aktif
                        </small>

                    </div>

                    <div>

                        <h3 class="fw-bold text-warning">
                            {{ $permintaanPending }}
                        </h3>

                        <small class="text-muted">
                            Permintaan Menunggu Approval
                        </small>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- TOP BARANG & STOK KRITIS --}}
    <div class="row g-4 mb-4">

        <div class="col-lg-6">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold">
                        Top Stok Barang
                    </h5>
                </div>

                <div class="card-body">

                    @forelse($barangTerbanyak as $item)

                    <div class="d-flex justify-content-between mb-3">

                        <span>
                            {{ $item->nama_barang }}
                        </span>

                        <strong>
                            {{ $item->stok }}
                        </strong>

                    </div>

                    @empty

                    <div class="text-center text-muted">

                        Belum ada data barang

                    </div>

                    @endforelse

                </div>

            </div>

        </div>

        <div class="col-lg-6">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold text-danger">
                        Stok Kritis
                    </h5>
                </div>

                <div class="card-body">

                    @forelse($stokKritis as $item)

                    <div class="d-flex justify-content-between mb-3">

                        <span>
                            {{ $item->nama_barang }}
                        </span>

                        <span class="badge bg-danger">

                            {{ $item->stok }}

                        </span>

                    </div>

                    @empty

                    <div class="text-center text-success">

                        Tidak ada stok kritis

                    </div>

                    @endforelse

                </div>

            </div>

        </div>

    </div>

    {{-- AKTIVITAS --}}
    <div class="row">

        <div class="col-lg-6">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold">
                        Barang Masuk Terakhir
                    </h5>
                </div>

                <div class="table-responsive">

                    <table class="table table-hover mb-0">

                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Barang</th>
                                <th>Qty</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($aktivitasMasuk as $item)

                            <tr>

                                <td>
                                    {{ $item->tanggal_masuk ?? '-' }}
                                </td>

                                <td>

                                    @foreach($item->details as $detail)

                                    {{ $detail->barang?->nama_barang ?? '-' }}

                                    @if(!$loop->last)
                                    <br>
                                    @endif

                                    @endforeach

                                </td>

                                <td>

                                    {{ $item->details->sum('qty') }}

                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="3" class="text-center">
                                    Tidak ada data
                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <div class="col-lg-6">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold">
                        Barang Keluar Terakhir
                    </h5>
                </div>

                <div class="table-responsive">

                    <table class="table table-hover mb-0">

                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Barang</th>
                                <th>Proyek</th>
                                <th>Qty</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($aktivitasKeluar as $item)

                            <tr>

                                <td>
                                    {{ $item->tanggal_keluar ?? '-' }}
                                </td>

                                <td>

                                    @foreach($item->details as $detail)

                                    {{ $detail->barang?->nama_barang ?? '-' }}

                                    @if(!$loop->last)
                                    <br>
                                    @endif

                                    @endforeach

                                </td>

                                <td>
                                    {{ $item->proyek?->nama_proyek ?? '-' }}
                                </td>

                                <td>

                                    {{ $item->details->sum('qty') }}

                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="4" class="text-center">
                                    Tidak ada data
                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const chart = document.getElementById('inventoryChart');

    if (chart) {

        const masuk =
            JSON.parse(
                chart.dataset.masuk
            );

        const keluar =
            JSON.parse(
                chart.dataset.keluar
            );

        new Chart(chart, {

            type: 'line',

            data: {

                labels: [
                    'Jan', 'Feb', 'Mar', 'Apr',
                    'Mei', 'Jun', 'Jul', 'Agu',
                    'Sep', 'Okt', 'Nov', 'Des'
                ],

                datasets: [

                    {
                        label: 'Barang Masuk',
                        data: masuk,
                        borderWidth: 3,
                        tension: .4
                    },

                    {
                        label: 'Barang Keluar',
                        data: keluar,
                        borderWidth: 3,
                        tension: .4
                    }

                ]
            },

            options: {

                responsive: true,

                plugins: {

                    legend: {
                        position: 'top'
                    }

                }

            }

        });

    }
</script>

@endpush

@endsection