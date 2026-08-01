@extends('layouts.app')

@section('content')

<div class="card shadow-sm">
    <div class="card-header">
        Edit Satuan
    </div>

    <div class="card-body">

        <form action="{{ route('satuan.update',$satuan->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Kode Satuan</label>
                <input type="text"
                    id="kode_satuan"
                    name="kode_satuan"
                    class="form-control"
                    value="{{ $satuan->kode_satuan }}">
            </div>

            <div class="mb-3">
                <label>Nama Satuan</label>
                <input type="text"
                    id="nama_satuan"
                    name="nama_satuan"
                    class="form-control"
                    value="{{ $satuan->nama_satuan }}">
            </div>

            <div class="mb-3">
                <label>Keterangan</label>
                <textarea name="keterangan"
                    id="keterangan"
                    class="form-control">{{ $satuan->keterangan }}</textarea>
            </div>

            <button class="btn btn-warning">
                Update
            </button>

            <a href="{{ route('satuan.index') }}"
               class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>
</div>

@endsection

@push('scripts')

<script>

$('#kode_satuan').on('input', function() {

    let kode = $(this).val();

    if(kode.length==0){
        $('#nama_satuan').val('');
        $('#keterangan').val('');

        return;
    }

    $.ajax({
        url: "{{ url('satuan/ajax') }}/"+kode,
        type:'GET',

        success: function(response){
            if(response.status){
                $('#nama_satuan').val(
                    response.data.nama_satuan
                );

                $('#keterangan').val(
                    response.data.keterangan
                );
            }else{
                $('#nama_satuan').val('');
                $('#keterangan').val('');
            }
        }
    });
});

</script>

@endpush