@extends('layouts.app')

@section('content')

<div class="card shadow">

    <div class="card-header">
        <h4>Detail Material Request</h4>
    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <tr>
                <th width="200">Nomor MR</th>
                <td>{{ $materialRequest->nomor_mr }}</td>
            </tr>

            <tr>
                <th>User</th>
                <td>{{ $materialRequest->user?->name ?? '-' }}</td>
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

                    @if($materialRequest->status == 'pending')

                        <span class="badge bg-warning">
                            Pending
                        </span>

                    @elseif($materialRequest->status == 'approved')

                        <span class="badge bg-success">
                            Approved
                        </span>

                    @elseif($materialRequest->status == 'processed')

                        <span class="badge bg-primary">
                            Processed
                        </span>

                    @elseif($materialRequest->status == 'rejected')

                        <span class="badge bg-danger">
                            Rejected
                        </span>

                    @endif

                </td>
            </tr>

        </table>

        <hr>

        <h5>Detail Barang</h5>

        <table class="table table-bordered">

            <thead>

                <tr>
                    <th>Barang</th>
                    <th>Qty</th>
                </tr>

            </thead>

            <tbody>

                @forelse($materialRequest->details as $detail)

                <tr>

                    <td>
                        {{ $detail->barang?->nama_barang ?? '-' }}
                    </td>

                    <td>
                        {{ $detail->qty }}
                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="2"
                        class="text-center">

                        Tidak ada detail barang

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

        <a href="{{ route('approval.index') }}"
           class="btn btn-secondary">

            Kembali

        </a>

    </div>

</div>

@endsection