@extends('layouts.app')

@section('title', 'Data Kategori')

@section('content')

<div class="card shadow-sm border-0">

    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="bi bi-tags-fill me-2"></i>
            Data Kategori
        </h5>

        <a href="{{ route('kategori.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>
            Tambah Kategori
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
       id="tableKategori">

    <thead>
        <tr>
            <th width="60">No</th>
            <th>Kode Kategori</th>
            <th>Nama Kategori</th>
            <th>Keterangan</th>
            <th width="150">Aksi</th>
        </tr>
    </thead>

    <tbody>

        @foreach($kategori as $item)
        <tr>

            <td>{{ $loop->iteration }}</td>

            <td>
                <span class="badge bg-primary">
                    {{ $item->kode_kategori }}
                </span>
            </td>

            <td>{{ $item->nama_kategori }}</td>

            <td>{{ $item->keterangan ?? '-' }}</td>

            <td>

                <div class="d-flex gap-2">

                    <a href="{{ route('kategori.edit', $item->id) }}"
                       class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil-square"></i>
                    </a>

                    <form action="{{ route('kategori.destroy', $item->id) }}"
                          method="POST"
                          class="d-inline form-delete">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i>
                        </button>

                    </form>

                </div>

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

$(document).ready(function() {

    $('#tableKategori').DataTable({
        responsive: true,
        autoWidth: false
    });

});

$(document).on('submit', '.form-delete', function(e) {

    e.preventDefault();

    let form = this;

    Swal.fire({
        title: 'Yakin?',
        text: 'Data kategori akan dihapus!',
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