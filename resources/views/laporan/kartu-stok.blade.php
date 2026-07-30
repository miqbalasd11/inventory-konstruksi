@extends('layouts.app')

@section('title','Kartu Stok')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">

                <i class="bi bi-journal-text"></i>
                Kartu Stok Barang

            </h5>

            <div class="d-flex gap-2">
                <a href="{{ route('laporan.kartu-stok.export', request()->query()) }}"
                   class="btn btn-success">
                    <i class="bi bi-file-earmark-excel"></i>
                    Excel
                </a>

                <a href="{{ route('laporan.kartu-stok.pdf', request()->query()) }}"
                   target="_blank"
                   class="btn btn-danger">
                    <i class="bi bi-file-earmark-pdf"></i>
                    PDF
                </a>
            </div>

        </div>

        <div class="card-body">

            <form method="GET">

                <div class="row">

                    <div class="col-md-4">

                        <select
                            name="barang_id"
                            class="form-select">

                            <option value="">
                                Pilih Barang
                            </option>

                            @foreach($barang as $item)

                                <option
                                    value="{{ $item->id }}"
                                    {{ request('barang_id') == $item->id ? 'selected':'' }}>

                                    {{ $item->nama_barang }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-2">

                        <button
                            class="btn btn-primary">

                            Tampilkan

                        </button>

                    </div>

                </div>

            </form>

            @if($barangDipilih)

            <hr>

            <div class="mb-3">

                <h5>

                    {{ $barangDipilih->nama_barang }}

                </h5>

                <small>

                    Stok Saat Ini :
                    <strong>
                        {{ $barangDipilih->stok }}
                    </strong>

                </small>

            </div>

            @php

                $saldo = 0;

            @endphp

            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead>

                        <tr>

                            <th>Tanggal</th>
                            <th>Referensi</th>
                            <th>Jenis</th>
                            <th>Masuk</th>
                            <th>Keluar</th>
                            <th>Saldo</th>

                        </tr>

                    </thead>

                    <tbody>

                    @foreach($transaksi as $trx)

                    @php

                        $saldo +=
                            $trx['qty_masuk'];

                        $saldo -=
                            $trx['qty_keluar'];

                    @endphp

                    <tr>

                        <td>
                            {{ $trx['tanggal'] }}
                        </td>

                        <td>
                            {{ $trx['referensi'] }}
                        </td>

                        <td>
                            {{ $trx['jenis'] }}
                        </td>

                        <td>
                            {{ $trx['qty_masuk'] }}
                        </td>

                        <td>
                            {{ $trx['qty_keluar'] }}
                        </td>

                        <td>

                            <strong>

                                {{ $saldo }}

                            </strong>

                        </td>

                    </tr>

                    @endforeach

                    </tbody>

                </table>

            </div>

            @endif

        </div>

    </div>

</div>

@endsection