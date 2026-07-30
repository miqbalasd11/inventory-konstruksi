@extends('layouts.app')

@section('title', 'Data Supplier')

@section('content')

<div class="card shadow-sm border-0">

    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="bi bi-truck me-2"></i>
            Data Supplier
        </h5>

        <a href="{{ route('supplier.create') }}"
            class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>
            Tambah Supplier
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
                id="tablesupplier">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Supplier</th>
                        <th>Nama Supplier</th>
                        <th>Telepon</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($supplier as $item)
                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>
                            <span class="badge bg-primary">
                                {{ $item->kode_supplier }}
                            </span>
                        </td>

                        <td>{{ $item->nama_supplier }}</td>

                        <td>{{ $item->telepon ?? '-' }}</td>

                        <td>{{ $item->email ?? '-' }}</td>

                        <td>{{ $item->alamat ?? '-' }}</td>

                        <td>

                            <div class="d-flex gap-2">

                                <a href="{{ route('supplier.edit', $item->id) }}"
                                    class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('supplier.destroy', $item->id) }}"
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
    $(document).ready(function () {

        $('#tablesupplier').DataTable({
            responsive: true,
            autoWidth: false
        });

    });

    $(document).on('submit', '.form-delete', function(e) {

        e.preventDefault();

        let form = this;

        Swal.fire({
            title: 'Yakin?',
            text: 'Data supplier akan dihapus!',
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