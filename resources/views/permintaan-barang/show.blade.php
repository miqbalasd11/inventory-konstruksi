@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between mb-4">

        <h3 class="fw-bold">
            Detail Permintaan Barang
        </h3>

        <a href="{{ route('permintaan-barang.index') }}"
           class="btn btn-secondary">
            Kembali
        </a>

    </div>

    <div class="card shadow border-0">

        <div class="card-body">

            <table class="table">

                <tr>
                    <th width="250">Kode Permintaan</th>
                    <td>{{ $permintaanBarang->kode_permintaan }}</td>
                </tr>

                <tr>
                    <th>Tanggal</th>
                    <td>{{ $permintaanBarang->tanggal }}</td>
                </tr>

                <tr>
                    <th>Proyek</th>
                    <td>
                        {{ $permintaanBarang->proyek->nama_proyek ?? '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Barang</th>
                    <td>
                        {{ $permintaanBarang->barang->nama_barang ?? '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Qty</th>
                    <td>{{ $permintaanBarang->qty }}</td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>

                        @if($permintaanBarang->status == 'Menunggu')
                            <span class="badge bg-warning">
                                Menunggu
                            </span>

                        @elseif($permintaanBarang->status == 'Disetujui')
                            <span class="badge bg-success">
                                Disetujui
                            </span>

                        @elseif($permintaanBarang->status == 'Ditolak')
                            <span class="badge bg-danger">
                                Ditolak
                            </span>

                        @else
                            <span class="badge bg-secondary">
                                {{ $permintaanBarang->status }}
                            </span>
                        @endif

                    </td>
                </tr>

                <tr>
                    <th>Pemohon</th>
                    <td>
                        {{ $permintaanBarang->user->name ?? '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Keterangan</th>
                    <td>
                        {{ $permintaanBarang->keterangan }}
                    </td>
                </tr>

                <tr>
                    <th>Disetujui Oleh</th>
                    <td>
                        {{ $permintaanBarang->approver->name ?? '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Tanggal Approval</th>
                    <td>
                        {{ $permintaanBarang->approved_at ?? '-' }}
                    </td>
                </tr>

            </table>

            @if(
                in_array(
                    Auth::user()?->role?->name,
                    ['Manajer Proyek', 'Manager Proyek', 'Manager', 'Super Admin'],
                    true
                ) &&
                $permintaanBarang->status === 'Menunggu'
            )
                <div class="mt-4 d-flex gap-2">
                    <form method="POST"
                          action="{{ route('permintaan.reject', $permintaanBarang->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            Tolak Permintaan
                        </button>
                    </form>

                    <form method="POST"
                          action="{{ route('permintaan.approve', $permintaanBarang->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            Setujui Permintaan
                        </button>
                    </form>
                </div>
            @endif

        </div>

    </div>

</div>

@endsection