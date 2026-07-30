@extends('layouts.app')

@section('title', 'Detail Barang Keluar')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">

                <i class="bi bi-box-arrow-up me-2"></i>

                Detail Barang Keluar

            </h5>

            <a href="{{ route('barang-keluar.index') }}"
                class="btn btn-secondary">

                <i class="bi bi-arrow-left"></i>
                Kembali

            </a>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <table class="table table-bordered">

                        <tr>

                            <th width="35%">
                                Nomor Keluar
                            </th>

                            <td>
                                {{ $barangKeluar->nomor_keluar }}
                            </td>

                        </tr>

                        <tr>

                            <th>
                                Tanggal Keluar
                            </th>

                            <td>

                                {{ \Carbon\Carbon::parse($barangKeluar->tanggal_keluar)->format('d-m-Y') }}

                            </td>

                        </tr>

                        <tr>

                            <th>
                                Proyek
                            </th>

                            <td>

                                {{ $barangKeluar->proyek?->nama_proyek ?? '-' }}

                            </td>

                        </tr>

                        <tr>

                            <th>
                                User
                            </th>

                            <td>

                                {{ $barangKeluar->user?->name ?? '-' }}

                            </td>

                        </tr>

                    </table>

                </div>

                <div class="col-md-6">

                    <table class="table table-bordered">

                        <tr>

                            <th width="35%">
                                Jumlah Item
                            </th>

                            <td>

                                <span class="badge bg-primary">

                                    {{ $barangKeluar->details->count() }}
                                    Item

                                </span>

                            </td>

                        </tr>

                        <tr>

                            <th>
                                Total Qty
                            </th>

                            <td>

                                {{ $barangKeluar->details->sum('qty') }}

                            </td>

                        </tr>

                        <tr>

                            <th>
                                Keterangan
                            </th>

                            <td>

                                {{ $barangKeluar->keterangan ?? '-' }}

                            </td>

                        </tr>

                    </table>

                </div>

            </div>

            <hr>

            <h6 class="fw-bold mb-3">

                Detail Barang

            </h6>

            <div class="table-responsive">

                <table class="table table-bordered table-striped">

                    <thead class="table-light">

                        <tr>

                            <th width="5%">
                                No
                            </th>

                            <th>
                                Nama Barang
                            </th>

                            <th width="15%">
                                Qty
                            </th>

                            <th>
                                Catatan
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($barangKeluar->details as $detail)

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

                                {{ $detail->catatan ?? '-' }}

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="4"
                                class="text-center text-muted">

                                Tidak ada detail barang

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                    <tfoot>

                        <tr>

                            <th colspan="2"
                                class="text-end">

                                Total Qty

                            </th>

                            <th>

                                {{ $barangKeluar->details->sum('qty') }}

                            </th>

                            <th></th>

                        </tr>

                    </tfoot>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection