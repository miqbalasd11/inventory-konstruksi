@extends('layouts.app')

@section('title', 'Data Barang')

@section('content')

<div class="card shadow-sm border-0">

    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="bi bi-box-seam-fill me-2"></i>
            Data Barang
        </h5>

        <a href="{{ route('barang.create') }}"
            class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>
            Tambah Barang
        </a>
    </div>

    <div class="card-body">

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}

            <button type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>
        </div>
        @endif

        <div class="table-responsive">

            <table class="table table-bordered table-striped align-middle"
                id="tablebarang">

                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Satuan</th>
                        <th>Stok</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($barang as $item)
                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $item->kode_barang }}</td>

                        <td>{{ $item->nama_barang }}</td>

                        <td>
                            {{ $item->kategori?->nama_kategori ?? '-' }}
                        </td>

                        <td>
                            {{ $item->satuan?->nama_satuan ?? '-' }}
                        </td>

                        <td>
                            @if($item->stok <= $item->stok_minimum)
                                <span class="badge bg-danger">
                                    {{ $item->stok }}
                                </span>
                            @else
                                <span class="badge bg-success">
                                    {{ $item->stok }}
                                </span>
                            @endif
                        </td>

                        <td>

                            <a href="{{ route('barang.edit', $item->id) }}"
                                class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <form action="{{ route('barang.destroy', $item->id) }}"
                                method="POST"
                                class="d-inline form-delete">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </button>

                            </form>

                        </td>

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

$(document).ready(function () {

    $('#tablebarang').DataTable({
        responsive: true,
        autoWidth: false
    });

});

$(document).on('submit', '.form-delete', function(e) {

    e.preventDefault();

    let form = this;

    Swal.fire({
        title: 'Yakin?',
        text: 'Data barang akan dihapus!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {

        if (result.isConfirmed) {
            form.submit();
        }

    });

});

</script>

@endpush