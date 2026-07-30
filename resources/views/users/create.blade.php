@extends('layouts.app')

@section('title','Tambah User')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white">

            <h4 class="fw-bold mb-0">
                <i class="bi bi-person-plus-fill text-primary me-2"></i>
                Tambah User
            </h4>

        </div>

        <div class="card-body">

            <form
                action="{{ route('users.store') }}"
                method="POST">

                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Nama
                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Role
                        </label>

                        <select
                            name="role_id"
                            class="form-select"
                            required>

                            <option value="">
                                Pilih Role
                            </option>

                            @foreach($roles as $role)

                                <option value="{{ $role->id }}">
                                    {{ $role->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Password
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Konfirmasi Password
                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            class="form-control"
                            required>

                    </div>

                </div>

                <div class="mt-3">

                    <button
                        type="submit"
                        class="btn btn-primary">

                        <i class="bi bi-save-fill"></i>
                        Simpan

                    </button>

                    <a href="{{ route('users.index') }}"
                       class="btn btn-secondary">

                        Kembali

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection