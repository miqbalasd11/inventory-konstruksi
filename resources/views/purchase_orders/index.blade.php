@extends('layouts.app')

@section('title', 'Purchase Order')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <div>
                <h5 class="mb-0 fw-bold">
                    Purchase Order
                </h5>
                <small class="text-muted">
                    Daftar Purchase Order Material
                </small>
            </div>

            <a href="{{ route('purchase-orders.create') }}"
               class="btn btn-primary btn-sm">

                <i class="bi bi-plus-circle me-1"></i>
                Buat PO

            </a>

        </div>

        <div class="card-body">

            @if(session('success'))

                <div class="alert alert-success alert-dismissible fade show">

                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert">
                    </button>

                </div>

            @endif

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>
                            <th width="60">No</th>
                            <th>No PO</th>
                            <th>No MR</th>
                            <th>Tanggal PO</th>
                            <th>Supplier</th>
                            <th class="text-end">Total</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" width="120">
                                Aksi
                            </th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($purchaseOrders as $item)

                        <tr>

                            <td>
                                {{ $purchaseOrders->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <strong>
                                    {{ $item->nomor_po }}
                                </strong>
                            </td>

                            <td>
                                {{ $item->materialRequest->nomor_mr ?? '-' }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($item->tanggal_po)->format('d-m-Y') }}
                            </td>

                            <td>
                                {{ $item->supplier->nama_supplier ?? '-' }}
                            </td>

                            <td class="text-end">

                                <strong>
                                    Rp {{ number_format($item->total,0,',','.') }}
                                </strong>

                            </td>

                            <td class="text-center">

                                @switch($item->status)

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
                                            {{ $item->status }}
                                        </span>

                                @endswitch

                            </td>

                            <td class="text-center">

                                <a href="{{ route('purchase-orders.show', $item->id) }}"
                                   class="btn btn-info btn-sm">

                                    <i class="bi bi-eye me-1"></i>
                                    Detail

                                </a>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="8" class="text-center py-4">

                                <i class="bi bi-inbox fs-4 d-block mb-2"></i>

                                <span class="text-muted">
                                    Data Purchase Order belum tersedia
                                </span>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3 d-flex justify-content-end">

                {{ $purchaseOrders->links() }}

            </div>

        </div>

    </div>

</div>

@endsection