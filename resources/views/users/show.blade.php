@extends('layouts.app')

@section('title','Detail User')

@section('content')

<div class="container-fluid">

    <div class="card shadow border-0">

        <div class="card-header bg-white">

            <h4 class="fw-bold mb-0">
                <i class="bi bi-person-badge-fill text-info me-2"></i>
                Detail User
            </h4>

        </div>

        <div class="card-body">

            <div class="text-center mb-4">

                <img
                    src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0D6EFD&color=fff&size=120"
                    class="rounded-circle shadow">

            </div>

            <table class="table table-bordered">

                <tr>
                    <th width="200">Nama</th>
                    <td>{{ $user->name }}</td>
                </tr>

                <tr>
                    <th>Email</th>
                    <td>{{ $user->email }}</td>
                </tr>

                <tr>
                    <th>Role</th>
                    <td>
                        {{ $user->role->name ?? '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Dibuat</th>
                    <td>
                        {{ $user->created_at->format('d F Y H:i') }}
                    </td>
                </tr>

                <tr>
                    <th>Update Terakhir</th>
                    <td>
                        {{ $user->updated_at->format('d F Y H:i') }}
                    </td>
                </tr>

            </table>

            <a href="{{ route('users.index') }}"
                class="mt-3 btn btn-secondary">

                <i class="bi bi-arrow-left"></i>
                Kembali

            </a>

        </div>

    </div>

</div>

@endsection