@extends('layouts.app')

@section('title', 'Barang Keluar')

@section('content')
<div class="container-fluid">

    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">
                <i class="bi bi-box-arrow-up me-2"></i>
                Data Barang Keluar
            </h5>

            <a href="{{ route('barang-keluar.create') }}"
               class="btn btn-primary">

                <i class="bi bi-plus-circle"></i>
                Tambah Data

            </a>

        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">

                <table
                    class="table table-bordered table-striped"
                    id="tableBarangKeluar">

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>No Keluar</th>

                            <th>Tanggal</th>

                            <th>Proyek</th>

                            <th>Jumlah Item</th>

                            <th>User</th>

                            <th>Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($barangKeluars as $item)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $item->nomor_keluar }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($item->tanggal_keluar)->format('d-m-Y') }}
                            </td>

                            <td>
                                {{ $item->proyek?->nama_proyek }}
                            </td>

                            <td>
                                {{ $item->details->count() }}
                            </td>

                            <td>
                                {{ $item->user?->name }}
                            </td>

                            <td>

                                <a href="{{ route('barang-keluar.show',$item->id) }}"
                                   class="btn btn-info btn-sm">

                                    <i class="bi bi-eye"></i>

                                </a>

                                <!-- <form
                                    action="{{ route('barang-keluar.destroy',$item->id) }}"
                                    method="POST"
                                    class="d-inline form-delete">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </form> -->

                            </td>

                        </tr>

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

$(document).ready(function () {

    $('#tableBarangKeluar').DataTable({

        responsive: true,
        autoWidth: false

    });

});

$(document).on(
    'submit',
    '.form-delete',
    function(e)
{

    e.preventDefault();

    let form = this;

    Swal.fire({

        title: 'Yakin?',

        text: 'Data barang keluar akan dihapus!',

        icon: 'warning',

        showCancelButton: true,

        confirmButtonText: 'Ya, Hapus',

        cancelButtonText: 'Batal'

    }).then((result) => {

        if(result.isConfirmed)
        {
            form.submit();
        }

    });

});

</script>

@endpush