@extends('layouts.app')

@section('title', 'Detail Barang Masuk')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between">

            <h5 class="mb-0">
                Detail Barang Masuk
            </h5>

            <a href="{{ route('barang-masuk.index') }}"
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
                                Nomor Masuk
                            </th>

                            <td>
                                {{ $barangMasuk->nomor_masuk }}
                            </td>
                        </tr>

                        <tr>
                            <th>Tanggal Masuk</th>

                            <td>
                                {{ \Carbon\Carbon::parse($barangMasuk->tanggal_masuk)->format('d-m-Y') }}
                            </td>
                        </tr>

                        <tr>
                            <th>Supplier</th>

                            <td>
                                {{ $barangMasuk->supplier?->nama_supplier ?? '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Purchase Order</th>

                            <td>
                                {{ $barangMasuk->purchaseOrder?->nomor_po ?? '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Dibuat Oleh</th>

                            <td>
                                {{ $barangMasuk->user?->name ?? '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Keterangan</th>

                            <td>
                                {{ $barangMasuk->keterangan ?? '-' }}
                            </td>
                        </tr>

                    </table>

                </div>

            </div>

            <hr>

            <h6 class="mb-3">
                Detail Barang
            </h6>

            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead class="table-light">

                        <tr>

                            <th width="60">
                                No
                            </th>

                            <th>
                                Barang
                            </th>

                            <th width="120">
                                Qty
                            </th>

                            <th width="180">
                                Harga
                            </th>

                            <th width="180">
                                Subtotal
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($barangMasuk->details as $detail)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $detail->barang?->nama_barang }}
                            </td>

                            <td>
                                {{ $detail->qty }}
                            </td>

                            <td>
                                Rp {{ number_format($detail->harga_beli,0,',','.') }}
                            </td>

                            <td>
                                Rp {{ number_format($detail->subtotal,0,',','.') }}
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

                    <tfoot>

                        <tr>

                            <th colspan="4"
                                class="text-end">

                                Total

                            </th>

                            <th>

                                Rp {{
                                    number_format(
                                        $barangMasuk->details->sum('subtotal'),
                                        0,
                                        ',',
                                        '.'
                                    )
                                }}

                            </th>

                        </tr>

                    </tfoot>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection