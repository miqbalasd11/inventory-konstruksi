
@extends('layouts.app')

@section('title','Permintaan Material')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Permintaan Material Proyek
            </h3>

            <small class="text-muted">
                Pengajuan kebutuhan material oleh Staff Lapangan
            </small>

        </div>

        @if(in_array(Auth::user()?->role?->name, ['Staff Proyek', 'Super Admin'], true))

        <a href="{{ route('permintaan-barang.create') }}"
            class="btn btn-primary">

            <i class="bi bi-plus-circle me-2"></i>
            Ajukan Permintaan

        </a>

        @endif

    </div>

    {{-- SUMMARY --}}
    <div class="row g-3 mb-4">

        <div class="col-md-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">
                        Total Permintaan
                    </small>

                    <h2 class="fw-bold mb-0">
                        {{ $permintaan->count() }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">
                        Menunggu Approval
                    </small>

                    <h2 class="fw-bold text-warning mb-0">
                        {{ $permintaan->where('status','Menunggu')->count() }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">
                        Disetujui
                    </small>

                    <h2 class="fw-bold text-success mb-0">
                        {{ $permintaan->where('status','Disetujui')->count() }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">
                        Ditolak
                    </small>

                    <h2 class="fw-bold text-danger mb-0">
                        {{ $permintaan->where('status','Ditolak')->count() }}
                    </h2>

                </div>

            </div>

        </div>

    </div>

    {{-- TABLE --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white">

            <h5 class="mb-0">
                Daftar Permintaan Material
            </h5>

        </div>

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead>

                    <tr>

                        <th>Kode</th>
                        <th>Tanggal</th>
                        <th>Proyek</th>
                        <th>Material</th>
                        <th>Qty</th>
                        <th>Pemohon</th>
                        <th>Status</th>
                        <th>Approval</th>
                        <th>Catatan</th>
                        <th width="250">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($permintaan as $item)

                    <tr>

                        <td>
                            <strong>
                                {{ $item->kode_permintaan }}
                            </strong>
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}
                        </td>

                        <td>
                            {{ $item->proyek->nama_proyek ?? '-' }}
                        </td>

                        <td>
                            {{ $item->barang->nama_barang ?? '-' }}
                        </td>

                        <td>
                            {{ number_format($item->qty) }}
                        </td>

                        <td>
                            {{ $item->user->name ?? '-' }}
                        </td>

                        <td>

                            @if($item->status == 'Menunggu')

                                <span class="badge bg-warning">
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

                            @if($item->approved_by)

                                <div class="fw-semibold">
                                    {{ $item->approver->name ?? '-' }}
                                </div>

                                <small class="text-muted">
                                    {{ $item->approved_at }}
                                </small>

                            @else

                                -

                            @endif

                        </td>

                        <td>
                            {{ $item->catatan_manager ?? '-' }}
                        </td>

                        <td>

                            {{-- Detail --}}
                            <a href="{{ route('permintaan-barang.show',$item->id) }}"
                                class="btn btn-info btn-sm">

                                <i class="bi bi-eye"></i>

                            </a>

                            {{-- Edit --}}
                            @if(
                                Auth::id() == $item->user_id &&
                                $item->status == 'Menunggu'
                            )

                            <a href="{{ route('permintaan-barang.edit',$item->id) }}"
                                class="btn btn-warning btn-sm">

                                <i class="bi bi-pencil-square"></i>

                            </a>

                            @endif

                            {{-- Hapus --}}
                            @if(
                                Auth::id() == $item->user_id &&
                                $item->status == 'Menunggu'
                            )

                            <form
                                action="{{ route('permintaan-barang.destroy',$item->id) }}"
                                method="POST"
                                class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin ingin menghapus data ini?')">

                                    <i class="bi bi-trash"></i>

                                </button>

                            </form>

                            @endif

                            {{-- Approve Reject Manager --}}
                            @if(
                                in_array(
                                    Auth::user()?->role?->name,
                                    ['Manajer Proyek', 'Manager Proyek', 'Manager', 'Super Admin'],
                                    true
                                ) &&
                                $item->status == 'Menunggu'
                            )

                            <form
                                action="{{ route('permintaan.approve',$item->id) }}"
                                method="POST"
                                class="d-inline">

                                @csrf

                                <button
                                    type="submit"
                                    class="btn btn-success btn-sm"
                                    onclick="return confirm('Setujui permintaan ini?')">

                                    <i class="bi bi-check-circle"></i>

                                </button>

                            </form>

                            <form
                                action="{{ route('permintaan.reject',$item->id) }}"
                                method="POST"
                                class="d-inline">

                                @csrf

                                <button
                                    type="submit"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Tolak permintaan ini?')">

                                    <i class="bi bi-x-circle"></i>

                                </button>

                            </form>

                            @endif

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="10"
                            class="text-center py-5">

                            Belum ada data permintaan material

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection

