@extends('layouts.app')

@section('title', 'Data satuan')

@section('content')

<div class="card shadow-sm border-0">

    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="bi bi-tags-fill me-2"></i>
            Data satuan
        </h5>

        <a href="{{ route('satuan.create') }}"
            class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>
            Tambah satuan
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
                id="tablesatuan">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Satuan</th>
                        <th>Keterangan</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($satuan as $item)
                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>
                            <span class="badge bg-primary">
                                {{ $item->kode_satuan }}
                            </span>
                        </td>

                        <td>{{ $item->nama_satuan }}</td>

                        <td>
                            {{ $item->keterangan ?? '-' }}
                        </td>

                        <td>

                            <div class="d-flex gap-2">

                                <a href="{{ route('satuan.edit', $item->id) }}"
                                    class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('satuan.destroy', $item->id) }}"
                                    method="POST"
                                    class="form-delete">

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

        $('#tableSatuan').DataTable({
            responsive: true,
            autoWidth: false
        });

    });

    $('.form-delete').submit(function(e) {

        e.preventDefault();

        let form = this;

        Swal.fire({
            title: 'Yakin?',
            text: 'Data satuan akan dihapus!',
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