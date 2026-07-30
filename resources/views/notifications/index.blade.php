@extends('layouts.app')

@section('title','Notifikasi')

@section('content')

<div class="card shadow-sm border-0">

    <div class="card-header bg-white">
        <h5 class="mb-0">
            Notifikasi
        </h5>
    </div>

    <div class="card-body">

        @forelse($notifications as $notif)

            <div class="border rounded p-3 mb-3">

                <h6 class="fw-bold">
                    {{ $notif->judul }}
                </h6>

                <p class="mb-1">
                    {{ $notif->pesan }}
                </p>

                <small class="text-muted">
                    {{ $notif->created_at->diffForHumans() }}
                </small>

                @if(!$notif->is_read)

                <form
                    action="{{ route('notifications.read',$notif->id) }}"
                    method="POST"
                    class="mt-2">

                    @csrf

                    <button
                        class="btn btn-sm btn-success">

                        Tandai Dibaca

                    </button>

                </form>

                @endif

            </div>

        @empty

            <div class="text-center text-muted">
                Belum ada notifikasi
            </div>

        @endforelse

    </div>

</div>

@endsection