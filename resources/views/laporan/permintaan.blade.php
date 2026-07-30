@extends('layouts.app')

@section('title', 'Laporan Permintaan Barang')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm">

        <div class="card-header">
            <h5 class="mb-0">
                Laporan Permintaan Barang
            </h5>
        </div>

        <div class="card-body">

            <div class="mb-3 d-flex gap-2">
                <a href="{{ route('laporan.permintaan.export', request()->query()) }}"
                   class="btn btn-success">
                    <i class="bi bi-file-earmark-excel"></i>
                    Export Excel
                </a>

                <a href="{{ route('laporan.permintaan.pdf', request()->query()) }}"
                   target="_blank"
                   class="btn btn-danger">
                    <i class="bi bi-file-earmark-pdf"></i>
                    Export PDF
                </a>
            </div>

            {{-- Filter --}}
            <form
                action="{{ route('laporan.permintaan') }}"
                method="GET"
                class="row g-3 mb-4">

                <div class="col-md-3">
                    <label class="form-label">
                        Tanggal Awal
                    </label>

                    <input
                        type="date"
                        name="tanggal_awal"
                        class="form-control"
                        value="{{ request('tanggal_awal') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">
                        Tanggal Akhir
                    </label>

                    <input
                        type="date"
                        name="tanggal_akhir"
                        class="form-control"
                        value="{{ request('tanggal_akhir') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">
                        Status
                    </label>

                    <select
                        name="status"
                        class="form-select">

                        <option value="">
                            Semua Status
                        </option>

                        <option value="Menunggu"
                            {{ request('status') == 'Menunggu' ? 'selected' : '' }}>
                            Menunggu
                        </option>

                        <option value="Disetujui"
                            {{ request('status') == 'Disetujui' ? 'selected' : '' }}>
                            Disetujui
                        </option>

                        <option value="Ditolak"
                            {{ request('status') == 'Ditolak' ? 'selected' : '' }}>
                            Ditolak
                        </option>

                    </select>
                </div>

                <div class="col-md-3 d-flex align-items-end">

                    <button
                        type="submit"
                        class="btn btn-primary me-2">
                        Filter
                    </button>

                    <a href="{{ route('laporan.permintaan') }}"
                        class="btn btn-secondary">
                        Reset
                    </a>

                </div>

            </form>

            {{-- Tabel --}}
            <div class="table-responsive">

                <table class="table table-bordered table-striped table-hover align-middle">

                    <thead >
                        <tr>
                            <th width="50">No</th>
                            <th>Kode Permintaan</th>
                            <th>Tanggal</th>
                            <th>Barang</th>
                            <th>Proyek</th>
                            <th>Qty</th>
                            <th>Pemohon</th>
                            <th>Status</th>
                            <th>Disetujui Oleh</th>
                            <th>Tanggal Approval</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse($permintaan as $item)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $item->kode_permintaan }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}
                            </td>

                            <td>
                                {{ $item->barang->nama_barang ?? '-' }}
                            </td>

                            <td>
                                {{ $item->proyek->nama_proyek ?? '-' }}
                            </td>

                            <td>
                                {{ number_format($item->qty) }}
                            </td>

                            <td>
                                {{ $item->user->name ?? '-' }}
                            </td>

                            <td>

                                @if($item->status == 'Menunggu')

                                    <span class="badge bg-warning text-dark">
                                        Menunggu
                                    </span>

                                @elseif($item->status == 'Disetujui')

                                    <span class="badge bg-success">
                                        Disetujui
                                    </span>

                                @elseif($item->status == 'Ditolak')

                                    <span class="badge bg-danger">
                                        Ditolak
                                    </span>

                                @endif

                            </td>

                            <td>
                                {{ $item->approver->name ?? '-' }}
                            </td>

                            <td>

                                @if($item->approved_at)

                                    {{ \Carbon\Carbon::parse($item->approved_at)->format('d-m-Y H:i') }}

                                @else

                                    -

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="10" class="text-center">
                                Tidak ada data permintaan barang
                            </td>
                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection