@extends('layouts.app')

@section('title','Laporan Material Request')

@section('content')

<div class="container-fluid">

    <div class="card shadow">

        <div class="card-header">
            <h5 class="mb-0">
                Laporan Material Request
            </h5>
        </div>

        <div class="card-body">

  <div class="mb-3 d-flex gap-2">
                <a href="{{ route('laporan.material-request.export', request()->query()) }}"
                   class="btn btn-success">
                    <i class="bi bi-file-earmark-excel"></i>
                    Export Excel
                </a>

                <a href="{{ route('laporan.material-request.pdf', request()->query()) }}"
                   target="_blank"
                   class="btn btn-danger">
                    <i class="bi bi-file-earmark-pdf"></i>
                    Export PDF
                </a>
            </div>

            <form method="GET">

                <div class="row mb-3">

                    <div class="col-md-3">

                        <select
                            name="status"
                            class="form-control">

                            <option value="">
                                Semua Status
                            </option>

                            <option value="pending">
                                Pending
                            </option>

                            <option value="approved">
                                Approved
                            </option>

                            <option value="rejected">
                                Rejected
                            </option>

                            <option value="processed">
                                Processed
                            </option>

                        </select>

                    </div>

                    <div class="col-md-2">

                        <button
                            class="btn btn-primary">

                            Filter

                        </button>

                    </div>

                </div>

            </form>

            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead>

                        <tr>
                            <th>No MR</th>
                            <th>Tanggal</th>
                            <th>User</th>
                            <th>Status</th>
                            <th>Jumlah Item</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($materialRequests as $item)

                        <tr>

                            <td>{{ $item->nomor_mr }}</td>

                            <td>
                                {{ $item->tanggal_request }}
                            </td>

                            <td>
                                {{ $item->user?->name }}
                            </td>

                            <td>
                                {{ ucfirst($item->status) }}
                            </td>

                            <td>
                                {{ $item->details->count() }}
                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="5"
                                class="text-center">

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

@endsection