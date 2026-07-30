@extends('layouts.app')

@section('title', 'Detail Purchase Order')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">
                Detail Purchase Order
            </h5>

            <a href="{{ route('purchase-orders.index') }}"
                class="btn btn-secondary btn-sm">

                Kembali

            </a>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <table class="table table-borderless">

                        <tr>
                            <th width="180">
                                Nomor PO
                            </th>

                            <td>
                                {{ $purchaseOrder->nomor_po }}
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Tanggal PO
                            </th>

                            <td>
                                {{ \Carbon\Carbon::parse($purchaseOrder->tanggal_po)->format('d-m-Y') }}
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Supplier
                            </th>

                            <td>
                                {{ optional($purchaseOrder->supplier)->nama_supplier ?? '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Status</th>

                            <td>

                                @switch($purchaseOrder->status)

                                @case('Draft')
                                <span class="badge bg-secondary">
                                    Draft
                                </span>
                                @break

                                @case('Dipesan')
                                <span class="badge bg-warning text-dark">
                                    Dipesan
                                </span>
                                @break

                                @case('Diterima')
                                <span class="badge bg-success">
                                    Diterima
                                </span>
                                @break

                                @case('Dibatalkan')
                                <span class="badge bg-danger">
                                    Dibatalkan
                                </span>
                                @break

                                @default
                                <span class="badge bg-dark">
                                    {{ $purchaseOrder->status }}
                                </span>

                                @endswitch

                            </td>
                        </tr>

                        <tr>
                            <th>Material Request</th>

                            <td>
                                {{ $purchaseOrder->materialRequest?->nomor_mr ?? '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Dibuat Oleh</th>

                            <td>
                                {{ $purchaseOrder->user?->name ?? '-' }}
                            </td>
                        </tr>
                    </table>

                </div>

            </div>
            @if($purchaseOrder->status == 'Draft')

            <form action="{{ route(
        'purchase-orders.kirim',
        $purchaseOrder->id
    ) }}"
                method="POST"
                class="mb-3">

                @csrf

                <button type="submit"
                    class="btn btn-warning">

                    Kirim PO

                </button>

            </form>

            @endif
            <hr>

            <h6 class="mb-3">
                Detail Barang
            </h6>

            <div class="table-responsive">

                <table class="table table-bordered table-striped">

                    <thead class="table-light">

                        <tr>
                            <th width="60">No</th>
                            <th>Barang</th>
                            <th width="120">Qty</th>
                            <th width="180">Harga</th>
                            <th width="200">Subtotal</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($purchaseOrder->details as $detail)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ optional($detail->barang)->nama_barang ?? '-' }}
                            </td>

                            <td>
                                {{ $detail->qty }}
                            </td>

                            <td>
                                Rp {{ number_format($detail->harga, 0, ',', '.') }}
                            </td>

                            <td>
                                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="5"
                                class="text-center">

                                Tidak ada data detail

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                    <tfoot>

                        <tr>

                            <th colspan="4"
                                class="text-end">

                                Total Purchase Order

                            </th>

                            <th>

                                Rp {{ number_format(
                                    $purchaseOrder->details->sum('subtotal'),
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </th>

                        </tr>

                    </tfoot>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection