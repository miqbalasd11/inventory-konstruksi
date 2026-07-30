@extends('layouts.app')

@section('title','Edit User')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white">

            <h4 class="fw-bold mb-0">
                <i class="bi bi-pencil-square text-warning me-2"></i>
                Edit User
            </h4>

        </div>

        <div class="card-body">

            <form
                action="{{ route('users.update',$user->id) }}"
                method="POST">

                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Nama
                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ $user->name }}"
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
                            value="{{ $user->email }}"
                            class="form-control"
                            required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Role
                        </label>

                        <select
                            name="role_id"
                            class="form-select">

                            @foreach($roles as $role)

                            <option
                                value="{{ $role->id }}"
                                {{ $user->role_id==$role->id ? 'selected':'' }}>

                                {{ $role->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Password Baru
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="form-control">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Konfirmasi Password
                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            class="form-control">

                    </div>

                </div>

                <button
                    type="submit"
                    class="btn btn-warning">

                    <i class="bi bi-check-circle-fill"></i>
                    Update

                </button>

                <a href="{{ route('users.index') }}"
                    class="btn btn-secondary">

                    Kembali

                </a>

            </form>

        </div>

    </div>

</div>

@endsection