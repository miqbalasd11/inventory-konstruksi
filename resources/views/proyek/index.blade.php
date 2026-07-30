@extends('layouts.app')

@section('title', 'Data Proyek')

@section('content')

<div class="container-fluid">

    <div class="row mb-4">

        <div class="col-md-6">

            <h3 class="fw-bold">

                <i class="fas fa-building me-2"></i>

                Data Proyek

            </h3>

            <small class="text-muted">

                Kelola seluruh proyek konstruksi perusahaan

            </small>

        </div>

        <div class="col-md-6 text-end">

            <a href="{{ route('proyek.create') }}"
               class="btn btn-primary shadow">

                <i class="fas fa-plus-circle"></i>

                Tambah Proyek

            </a>

        </div>

    </div>

    @if(session('success'))

    <div class="alert alert-success">

        {{ session('success') }}

    </div>

    @endif

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white">

            <h5 class="mb-0">

                <i class="fas fa-list me-2"></i>

                Daftar Proyek

            </h5>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead
                        class="text-white"
                        style="background:#0f172a;">

                        <tr>

                            <th>No</th>

                            <th>Kode Proyek</th>

                            <th>Nama Proyek</th>

                            <th>Lokasi</th>

                            <th>Tanggal Mulai</th>

                            <th>Tanggal Selesai</th>

                            <th>MR</th>

                            <th>Status</th>

                            <th width="180">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($proyek as $item)

                        <tr>

                            <td>

                                {{ method_exists($proyek,'firstItem')
                                    ? $proyek->firstItem() + $loop->index
                                    : $loop->iteration }}

                            </td>

                            <td>

                                <span class="fw-bold text-primary">

                                    {{ $item->kode_proyek }}

                                </span>

                            </td>

                            <td>

                                {{ $item->nama_proyek }}

                            </td>

                            <td>

                                {{ $item->lokasi }}

                            </td>

                            <td>

                                {{ \Carbon\Carbon::parse(
                                    $item->tanggal_mulai
                                )->format('d-m-Y') }}

                            </td>

                            <td>

                                {{ $item->tanggal_selesai
                                    ? \Carbon\Carbon::parse(
                                        $item->tanggal_selesai
                                      )->format('d-m-Y')
                                    : '-' }}

                            </td>

                            <td>

                                <span class="badge bg-primary">

                                    {{ $item->material_requests_count ?? 0 }}

                                </span>

                            </td>

                            <td>

                                @if($item->status == 'Aktif')

                                    <span class="badge bg-success">

                                        Aktif

                                    </span>

                                @elseif($item->status == 'Pending')

                                    <span class="badge bg-warning text-dark">

                                        Pending

                                    </span>

                                @elseif($item->status == 'Selesai')

                                    <span class="badge bg-secondary">

                                        Selesai

                                    </span>

                                @else

                                    <span class="badge bg-dark">

                                        {{ $item->status }}

                                    </span>

                                @endif

                            </td>

                            <td>

                                <a href="{{ route('proyek.show',$item->id) }}"
                                   class="btn btn-info btn-sm">

                                    <i class="bi bi-eye"></i>

                                </a>

                                <a href="{{ route('proyek.edit',$item->id) }}"
                                   class="btn btn-warning btn-sm">

                                    <i class="bi bi-pencil-square"></i>

                                </a>

                                <form action="{{ route('proyek.destroy',$item->id) }}"
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

                        @empty

                        <tr>

                            <td colspan="9"
                                class="text-center">

                                Belum ada data proyek

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            @if(method_exists($proyek,'links'))

            <div class="mt-3">

                {{ $proyek->links() }}

            </div>

            @endif

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>

document
.querySelectorAll('.form-delete')
.forEach(function(form){

    form.addEventListener(
    'submit',
    function(e){

        if(
            !confirm(
                'Yakin ingin menghapus proyek ini?'
            )
        ){

            e.preventDefault();

        }

    });

});

</script>

@endpush