@extends('layouts.app')

@section('title','Laporan Purchase Order')

@section('content')

<div class="container-fluid">

    <div class="card shadow">

        <div class="card-header">
            <h5 class="mb-0">
                Laporan Purchase Order
            </h5>
        </div>

        <div class="card-body">
            <div class="mb-3 d-flex gap-2">
                <a href="{{ route('laporan.purchase-order.export', request()->query()) }}"
                    class="btn btn-success">
                    <i class="bi bi-file-earmark-excel"></i>
                    Export Excel
                </a>

                <a href="{{ route('laporan.purchase-order.pdf', request()->query()) }}"
                    target="_blank"
                    class="btn btn-danger">
                    <i class="bi bi-file-earmark-pdf"></i>
                    Export PDF
                </a>
            </div>
            <form method="GET">

                <div class="row mb-3">

                    <div class="col-md-3">

                        <input
                            type="date"
                            name="tanggal_awal"
                            class="form-control">

                    </div>

                    <div class="col-md-3">

                        <input
                            type="date"
                            name="tanggal_akhir"
                            class="form-control">

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

                            <th>No PO</th>
                            <th>Tanggal</th>
                            <th>Supplier</th>
                            <th>No MR</th>
                            <th>Status</th>
                            <th>Total</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($purchaseOrders as $item)

                        <tr>

                            <td>
                                {{ $item->nomor_po }}
                            </td>

                            <td>
                                {{ $item->tanggal_po }}
                            </td>

                            <td>
                                {{ $item->supplier?->nama_supplier }}
                            </td>

                            <td>
                                {{ $item->materialRequest?->nomor_mr }}
                            </td>

                            <td>
                                {{ $item->status }}
                            </td>

                            <td>

                                Rp
                                {{ number_format($item->total,0,',','.') }}

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="6"
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