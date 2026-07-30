@extends('layouts.app')

@section('title', 'Profile Saya')

@section('content')

<div class="container-fluid">

    {{-- PROFILE HEADER --}}
    <div class="card border-0 shadow-sm mb-4 overflow-hidden">

        <div class="card-body p-0">

            <div class="bg-primary bg-gradient text-white p-5">

                <div class="row align-items-center">

                    <div class="col-lg-2 text-center">

                        <img
                            src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=ffffff&color=0D6EFD&size=256"
                            class="rounded-circle border-4 border-white shadow"
                            width="140">

                    </div>

                    <div class="col-lg-10">

                        <h2 class="fw-bold mb-1">
                            {{ Auth::user()->name }}
                        </h2>

                        <p class="mb-2 opacity-75">
                            {{ Auth::user()->email }}
                        </p>

                        <span class="badge bg-light text-primary px-3 py-2">
                            <i class="bi bi-person-badge-fill me-1"></i>
                            {{ Auth::user()->role->name ?? 'User' }}
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- INFO CARD --}}
    <div class="row mb-4">

        <div class="col-lg-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body text-center">

                    <i class="bi bi-calendar-check text-primary fs-1"></i>

                    <h3 class="fw-bold mt-3">
                        {{ Auth::user()->created_at->format('d M Y') }}
                    </h3>

                    <small class="text-muted">
                        Tanggal Bergabung
                    </small>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body text-center">

                    <i class="bi bi-shield-check text-success fs-1"></i>

                    <h3 class="fw-bold mt-3">
                        Aktif
                    </h3>

                    <small class="text-muted">
                        Status Akun
                    </small>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body text-center">

                    <i class="bi bi-clock-history text-warning fs-1"></i>

                    <h3 class="fw-bold mt-3">
                        {{ Auth::user()->updated_at->diffForHumans() }}
                    </h3>

                    <small class="text-muted">
                        Update Terakhir
                    </small>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body text-center">

                    <i class="bi bi-person-workspace text-info fs-1"></i>

                    <h3 class="fw-bold mt-3">
                        {{ Auth::user()->role->name ?? '-' }}
                    </h3>

                    <small class="text-muted">
                        Hak Akses
                    </small>

                </div>

            </div>

        </div>

    </div>

    {{-- PROFILE SETTINGS --}}
    <div class="row">

        <div class="col-lg-8">

            {{-- PROFILE INFORMATION --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white">

                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-person-circle me-2"></i>
                        Informasi Akun
                    </h5>

                </div>

                <div class="card-body">

                    @include('profile.partials.update-profile-information-form')

                </div>

            </div>

            {{-- PASSWORD --}}
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">

                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-lock-fill me-2"></i>
                        Keamanan Akun
                    </h5>

                </div>

                <div class="card-body">

                    @include('profile.partials.update-password-form')

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            {{-- ACCOUNT SUMMARY --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white">

                    <h5 class="fw-bold mb-0">
                        Ringkasan Akun
                    </h5>

                </div>

                <div class="card-body">

                    <ul class="list-group list-group-flush">

                        <li class="list-group-item d-flex justify-content-between">

                            <span>Nama</span>

                            <strong>{{ Auth::user()->name }}</strong>

                        </li>

                        <li class="list-group-item d-flex justify-content-between">

                            <span>Email</span>

                            <strong>{{ Auth::user()->email }}</strong>

                        </li>

                        <li class="list-group-item d-flex justify-content-between">

                            <span>Role</span>

                            <strong>{{ Auth::user()->role->name ?? '-' }}</strong>

                        </li>

                        <li class="list-group-item d-flex justify-content-between">

                            <span>Bergabung</span>

                            <strong>
                                {{ Auth::user()->created_at->format('d/m/Y') }}
                            </strong>

                        </li>

                    </ul>

                </div>

            </div>

            {{-- DANGER ZONE --}}
            <div class="card shadow-sm border-start border-danger border-4">

                <div class="card-header bg-white">

                    <h5 class="fw-bold text-danger mb-0">
                        Danger Zone
                    </h5>

                </div>

                <div class="card-body">

                    <p class="text-muted">
                        Menghapus akun akan menghilangkan seluruh data akses pengguna secara permanen.
                    </p>

                    @include('profile.partials.delete-user-form')

                </div>

            </div>

        </div>

    </div>

</div>

@endsection