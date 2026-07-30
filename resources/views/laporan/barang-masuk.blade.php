@extends('layouts.app')

@section('title', 'Laporan Barang Masuk')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white">

            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <h4 class="mb-1 fw-bold">
                        Laporan Barang Masuk
                    </h4>

                    <small class="text-muted">
                        Riwayat seluruh transaksi barang masuk
                    </small>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('laporan.barang-masuk.export', request()->query()) }}"
                        class="btn btn-success">
                        <i class="bi bi-file-earmark-excel"></i>
                        Excel
                    </a>

                    <a href="{{ route('laporan.barang-masuk.pdf', request()->query()) }}"
                        target="_blank"
                        class="btn btn-danger">
                        <i class="bi bi-file-earmark-pdf"></i>
                        PDF
                    </a>
                </div>

            </div>

        </div>

        <div class="card-body">

            <form method="GET"
                class="row g-3 mb-4">

                <div class="col-md-4">
                    <label>Tanggal Awal</label>
                    <input type="date"
                        name="tanggal_awal"
                        value="{{ request('tanggal_awal') }}"
                        class="form-control">
                </div>

                <div class="col-md-4">
                    <label>Tanggal Akhir</label>
                    <input type="date"
                        name="tanggal_akhir"
                        value="{{ request('tanggal_akhir') }}"
                        class="form-control">
                </div>

                <div class="col-md-4 d-flex align-items-end">

                    <button class="btn btn-success me-2">
                        Filter
                    </button>

                    <a href="{{ route('laporan.barang-masuk') }}"
                        class="btn btn-secondary">
                        Reset
                    </a>

                </div>

            </form>

            <div id="print-area">
                <table class="table table-bordered table-striped"
                    id="tableBarangMasuk">

                    <thead>

                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Barang</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Total</th>
                            <th>User</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($barangMasuk as $masuk)
                            @foreach($masuk->details as $detail)
                            <tr>
                                <td>{{ $masuk->nomor_masuk }}</td>
                                <td>{{ $masuk->tanggal_masuk }}</td>
                                <td>{{ $detail->barang->nama_barang ?? '-' }}</td>
                                <td>{{ $detail->qty }}</td>
                                <td>{{ number_format($detail->harga_beli,0,',','.') }}</td>
                                <td>{{ number_format($detail->subtotal,0,',','.') }}</td>
                                <td>{{ $masuk->user->name ?? '-' }}</td>
                            </tr>
                            @endforeach
                        @endforeach

                    </tbody>

                </table>
            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#tableBarangMasuk').DataTable({
            responsive: true
        });
    });

    function printTable() {
        let content =
            document.getElementById('print-area').innerHTML;

        let printWindow =
            window.open('', '', 'width=1000,height=700');

        printWindow.document.write(`
        <html>
        <head>

            <title>Laporan Barang Masuk</title>

            <style>

                body{
                    font-family:Arial,sans-serif;
                    padding:20px;
                }

                h2{
                    text-align:center;
                    margin-bottom:20px;
                }

                table{
                    width:100%;
                    border-collapse:collapse;
                }

                table,th,td{
                    border:1px solid #000;
                }

                th,td{
                    padding:8px;
                    text-align:left;
                }

                th{
                    background:#f0f0f0;
                }

            </style>

        </head>

        <body>

            <h2>
                LAPORAN BARANG MASUK
            </h2>

            ${content}

        </body>

        </html>
    `);

        printWindow.document.close();

        printWindow.print();
    }
</script>
@endpush