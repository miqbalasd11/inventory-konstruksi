@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <div>

                <h4 class="mb-0 fw-bold">
                    <i class="bi bi-people-fill text-primary me-2"></i>
                    Manajemen User
                </h4>

                <small class="text-muted">
                    Kelola pengguna dan hak akses sistem
                </small>

            </div>

            <a href="{{ route('users.create') }}"
               class="btn btn-primary">

                <i class="bi bi-plus-circle-fill me-1"></i>
                Tambah User

            </a>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle"
                    id="datatable">

                    <thead>

                        <tr>

                            <th width="50">No</th>

                            <th>Nama</th>

                            <th>Email</th>

                            <th>Role</th>

                            <th>Dibuat</th>

                            <th width="180">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($users as $user)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>

                                <div class="d-flex align-items-center">

                                    <img
                                        src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0D6EFD&color=fff"
                                        width="40"
                                        class="rounded-circle me-2">

                                    <div>

                                        <div class="fw-semibold">
                                            {{ $user->name }}
                                        </div>

                                    </div>

                                </div>

                            </td>

                            <td>
                                {{ $user->email }}
                            </td>

                            <td>

                                <span class="badge bg-primary">

                                    {{ $user->role->name ?? '-' }}

                                </span>

                            </td>

                            <td>

                                {{ $user->created_at->format('d M Y') }}

                            </td>

                            <td>

                                <a href="{{ route('users.show',$user->id) }}"
                                   class="btn btn-info btn-sm">

                                    <i class="bi bi-eye-fill"></i>

                                </a>

                                <a href="{{ route('users.edit',$user->id) }}"
                                   class="btn btn-warning btn-sm">

                                    <i class="bi bi-pencil-fill"></i>

                                </a>

                                <form
                                    action="{{ route('users.destroy',$user->id) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus user ini?')">

                                        <i class="bi bi-trash-fill"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="6"
                                class="text-center py-4">

                                <i class="bi bi-inbox fs-1 text-secondary"></i>

                                <div class="mt-2">
                                    Belum ada data user
                                </div>

                            </td>

                        </tr>

                        @endforelse

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

    $('#datatable').DataTable({

        responsive: true,

        language: {

            search: "Cari:",

            lengthMenu:
                "Tampilkan _MENU_ data",

            zeroRecords:
                "Data tidak ditemukan",

            info:
                "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",

            paginate: {

                first: "Awal",
                last: "Akhir",
                next: "→",
                previous: "←"

            }

        }

    });

});

</script>

@endpush