@extends('layouts.app')

@section('title','Audit Trail')

@section('content')

<div class="card shadow-sm">

    <div class="card-header">
        <h5 class="mb-0">
            Audit Trail
        </h5>
    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <thead>
                <tr>
                    <th>No</th>
                    <th>User</th>
                    <th>Aktivitas</th>
                    <th>Deskripsi</th>
                    <th>IP</th>
                    <th>Waktu</th>
                </tr>
            </thead>

            <tbody>

                @foreach($logs as $log)

                <tr>

                    <td>
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ $log->user->name ?? '-' }}
                    </td>

                    <td>
                        {{ $log->aktivitas }}
                    </td>

                    <td>
                        {{ $log->deskripsi }}
                    </td>

                    <td>
                        {{ $log->ip_address }}
                    </td>

                    <td>
                        {{ $log->created_at->format('d-m-Y H:i') }}
                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

        {{ $logs->links() }}

    </div>

</div>

@endsection