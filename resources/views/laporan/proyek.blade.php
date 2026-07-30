@extends('layouts.app')

@section('title', 'Laporan Material Proyek')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white">

            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <h4 class="mb-1 fw-bold">
                        Laporan Material Proyek
                    </h4>

                    <small class="text-muted">
                        Rekap penggunaan material per proyek
                    </small>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('laporan.proyek.export') }}"
                       class="btn btn-success">
                        <i class="bi bi-file-earmark-excel"></i>
                        Excel
                    </a>

                    <a href="{{ route('laporan.proyek.pdf') }}"
                       target="_blank"
                       class="btn btn-danger">
                        <i class="bi bi-file-earmark-pdf"></i>
                        PDF
                    </a>
                </div>

            </div>

        </div>

        <div class="card-body">

            <table class="table table-bordered table-striped"
                   id="tableProyek">

                <thead>

                    <tr>
                        <th>No</th>
                        <th>Proyek</th>
                        <th>Barang</th>
                        <th>Total Pakai</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($laporan as $item)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ optional($item->proyek)->nama_proyek }}</td>

                        <td>{{ optional($item->barang)->nama_barang }}</td>

                        <td>{{ $item->total_pakai }}</td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#tableProyek').DataTable({
        responsive:true
    });
});
</script>
@endpush
