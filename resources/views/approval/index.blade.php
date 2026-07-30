@extends('layouts.app')

@section('content')

<div class="card shadow">


<div class="card-header">

    <h4>Approval Material Request</h4>

</div>

<div class="card-body">

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <table class="table table-bordered table-striped">

        <thead>

            <tr>
                <th>No MR</th>
                <th>Barang</th>
                <th>User</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th width="250">Aksi</th>
            </tr>

        </thead>

        <tbody>

            @forelse($requests as $item)

            <tr>

                <td>
                    {{ $item->nomor_mr }}
                </td>

                <td>

                    @foreach($item->details as $detail)

                        <span class="badge bg-primary">
                            {{ $detail->barang?->nama_barang ?? '-' }}
                        </span>

                    @endforeach

                </td>

                <td>
                    {{ $item->user?->name ?? '-' }}
                </td>

                <td>
                    {{ \Carbon\Carbon::parse($item->tanggal_request)->translatedFormat('d F Y') }}
                </td>

                <td>

                    @if($item->status == 'pending')

                        <span class="badge bg-warning">
                            Pending
                        </span>

                    @elseif($item->status == 'approved')

                        <span class="badge bg-success">
                            Approved
                        </span>

                    @elseif($item->status == 'rejected')

                        <span class="badge bg-danger">
                            Rejected
                        </span>

                    @endif

                </td>

               <td>

    @if($item->status == 'pending')

        <form action="{{ route('approval.approve',$item->id) }}"
              method="POST"
              class="d-inline">

            @csrf

            <button type="submit"
                    class="btn btn-success btn-sm">

                Approve

            </button>

        </form>

        <form action="{{ route('approval.reject',$item->id) }}"
              method="POST"
              class="d-inline">

            @csrf

            <button type="submit"
                    class="btn btn-danger btn-sm">

                Reject

            </button>

        </form>

    @endif

 @if($item->status == 'approved')

<a href="{{ route('purchase-orders.createFromMR', $item->id) }}"
   class="btn btn-danger btn-sm">
    TEST PO {{ route('purchase-orders.createFromMR', $item->id) }}
</a>

@endif

    <a href="{{ route('approval.show',$item->id) }}"
       class="btn btn-info btn-sm">

        Detail

    </a>

</td>

            </tr>

            @empty

            <tr>

                <td colspan="6"
                    class="text-center">

                    Tidak ada Material Request yang menunggu approval

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>


</div>

@endsection
