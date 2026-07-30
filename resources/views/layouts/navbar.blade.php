@php

$notifCount = \App\Models\Notification::where(
    'user_id',
    Auth::id()
)
->where('is_read', false)
->count();

$notifList = \App\Models\Notification::where(
    'user_id',
    Auth::id()
)
->latest()
->take(5)
->get();

@endphp

<nav class="navbar navbar-expand-lg bg-white shadow-sm px-4">

    <div class="container-fluid">

        <div>

            <h5 class="mb-0 fw-bold text-dark">
                Manajemen Inventory Konstruksi
            </h5>

            <small class="text-muted">
                Inventory Management System
            </small>

        </div>

        <div class="d-flex align-items-center gap-4">

            {{-- NOTIFIKASI --}}
            <div class="dropdown">

                <a href="#"
                   class="text-dark position-relative text-decoration-none"
                   data-bs-toggle="dropdown">

                    <i class="bi bi-bell-fill fs-4"></i>

                    @if($notifCount > 0)

                        <span
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">

                            {{ $notifCount }}

                        </span>

                    @endif

                </a>

                <div
                    class="dropdown-menu dropdown-menu-end border-0 shadow-lg p-0"
                    style="width: 380px; border-radius:15px; overflow:hidden;">

                    <div class="p-3 bg-primary text-white">

                        <div class="d-flex justify-content-between align-items-center">

                            <h6 class="mb-0">
                                Notifikasi
                            </h6>

                            <span class="badge bg-light text-primary">

                                {{ $notifCount }}

                            </span>

                        </div>

                    </div>

                    <div style="max-height:400px;overflow-y:auto;">

                        @forelse($notifList as $notif)

                        <div class="p-3 border-bottom">

                            <div class="fw-semibold text-dark">

                                {{ $notif->judul }}

                            </div>

                            <small class="text-muted d-block mb-1">

                                {{ $notif->pesan }}

                            </small>

                            <small class="text-secondary">

                                {{ $notif->created_at->diffForHumans() }}

                            </small>

                            @if(!$notif->is_read)

                            <form
                                action="{{ route('notifications.read',$notif->id) }}"
                                method="POST"
                                class="mt-2">

                                @csrf

                                <button
                                    class="btn btn-success btn-sm">

                                    <i class="bi bi-check-circle"></i>
                                    Tandai Dibaca

                                </button>

                            </form>

                            @endif

                        </div>

                        @empty

                        <div class="text-center p-4">

                            <i class="bi bi-bell-slash fs-1 text-muted"></i>

                            <p class="text-muted mt-2 mb-0">

                                Tidak ada notifikasi

                            </p>

                        </div>

                        @endforelse

                    </div>

                    <div class="p-2 bg-light text-center">

                        <a
                            href="{{ route('notifications.index') }}"
                            class="btn btn-outline-primary btn-sm">

                            Lihat Semua Notifikasi

                        </a>

                    </div>

                </div>

            </div>

            {{-- USER DROPDOWN --}}
            <div class="dropdown">

                <a href="#"
                   class="d-flex align-items-center text-decoration-none dropdown-toggle"
                   data-bs-toggle="dropdown">

                    <img
                        src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D6EFD&color=fff"
                        width="42"
                        height="42"
                        class="rounded-circle shadow-sm me-2">

                    <div class="text-start">

                        <div class="fw-semibold text-dark">

                            {{ Auth::user()->name }}

                        </div>

                        <small class="text-muted">

                            {{ Auth::user()->role->name ?? 'User' }}

                        </small>

                    </div>

                </a>

                <ul class="dropdown-menu dropdown-menu-end border-0 shadow">

                    <li class="px-3 py-2 border-bottom">

                        <div class="fw-bold">

                            {{ Auth::user()->name }}

                        </div>

                        <small class="text-muted">

                            {{ Auth::user()->email }}

                        </small>

                    </li>

                    <li>

                        <a
                            class="dropdown-item"
                            href="{{ route('profile.edit') }}">

                            <i class="bi bi-person-circle me-2"></i>
                            Profile

                        </a>

                    </li>

                    <li>

                        <a
                            class="dropdown-item"
                            href="{{ route('admin.dashboard') }}">

                            <i class="bi bi-speedometer2 me-2"></i>
                            Dashboard

                        </a>

                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>

                        <form
                            method="POST"
                            action="{{ route('logout') }}">

                            @csrf

                            <button
                                type="submit"
                                class="dropdown-item text-danger">

                                <i class="bi bi-box-arrow-right me-2"></i>
                                Logout

                            </button>

                        </form>

                    </li>

                </ul>

            </div>

        </div>

    </div>

</nav>