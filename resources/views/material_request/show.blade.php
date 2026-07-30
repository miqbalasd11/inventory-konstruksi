@extends('layouts.app')

@section('content')

<div class="card shadow">

    <div class="card-header">
        Detail Material Request
    </div>

    <div class="card-body">

        <table class="table">

            <tr>
                <th>No MR</th>
                <td>{{ $materialRequest->nomor_mr }}</td>
            </tr>

            <tr>
                <th>User</th>
                <td>{{ $materialRequest->user->name }}</td>
            </tr>

            <tr>
                <th>Tanggal Request</th>
                <td>
                    {{ \Carbon\Carbon::parse($materialRequest->tanggal_request)->translatedFormat('d F Y') }}
                </td>
            </tr>

            <tr>
                <th>Status</th>
                <td>

                    @if($materialRequest->status=='pending')
                        <span class="badge bg-warning">
                            Pending
                        </span>

                    @elseif($materialRequest->status=='approved')
                        <span class="badge bg-success">
                            Approved
                        </span>

                    @elseif($materialRequest->status=='rejected')
                        <span class="badge bg-danger">
                            Rejected
                        </span>
                    @endif

                </td>
            </tr>

            <tr>
                <th>Keterangan</th>
                <td>
                    {{ $materialRequest->keterangan }}
                </td>
            </tr>

        </table>

        <hr>

        <h5>Detail Barang</h5>

        <table class="table table-bordered">

            <thead>

                <tr>
                    <th>Barang</th>
                    <th>Kategori</th>
                    <th>Qty</th>
                    <th>Catatan</th>
                </tr>

            </thead>

            <tbody>

                @forelse($materialRequest->details as $detail)

                <tr>

                    <td>
                        {{ $detail->barang->nama_barang ?? '-' }}
                    </td>

                    <td>
                        {{ $detail->kategori->nama_kategori ?? '-' }}
                    </td>

                    <td>
                        {{ $detail->qty }}
                    </td>

                    <td>
                        {{ $detail->catatan }}
                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="4" class="text-center">
                        Tidak ada detail barang
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

        <a href="{{ route('material-request.index') }}"
            class="btn btn-secondary mt-4">

            Kembali

        </a>

    </div>

</div>

@endsection