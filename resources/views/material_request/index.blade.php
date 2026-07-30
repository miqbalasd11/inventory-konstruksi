@extends('layouts.app')

@section('title', 'Material Request')

@section('content')

<div class="container-fluid">

    <div class="card shadow">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h4 class="mb-0">Material Request</h4>

            <a href="{{ route('material-request.create') }}"
                class="btn btn-primary">
                Tambah Request
            </a>

        </div>

        <div class="card-body">

            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <div class="table-responsive">

                <table class="table table-bordered table-striped">

                    <thead>
                        <tr>
                            <th>No MR</th>
                            <th>Barang</th>
                            <th>Kategori</th>
                            <th>User</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($requests as $item)

                        <tr>

                            <td>{{ $item->nomor_mr }}</td>

                            <td>

                                @forelse($item->details as $detail)

                                    <span class="badge bg-primary">
                                        {{ $detail->barang?->nama_barang ?? '-' }}
                                    </span>

                                @empty

                                    <span class="text-muted">-</span>

                                @endforelse

                            </td>

                            <td>

                                @forelse($item->details as $detail)

                                    <span class="badge bg-info">
                                        {{ $detail->kategori?->nama_kategori ?? '-' }}
                                    </span>

                                @empty

                                    <span class="text-muted">-</span>

                                @endforelse

                            </td>

                            <td>
                                {{ $item->user?->name ?? '-' }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($item->tanggal_request)->format('d-m-Y') }}
                            </td>

                            <td>

                                @if($item->status == 'pending')

                                    <span class="badge bg-warning">
                                        Pending
                                    </span>

                                @elseif($item->status == 'approved')

                                    <span class="badge bg-success">
                                        Approved
                                    </span>

                                @elseif($item->status == 'rejected')

                                    <span class="badge bg-danger">
                                        Rejected
                                    </span>

                                @endif

                            </td>

                            <td>

                                <a href="{{ route('material-request.show', $item->id) }}"
                                    class="btn btn-info btn-sm">
                                    Detail
                                </a>

                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="7" class="text-center">
                                Data Material Request belum tersedia
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">
                {{ $requests->links() }}
            </div>

        </div>

    </div>

</div>

@endsection