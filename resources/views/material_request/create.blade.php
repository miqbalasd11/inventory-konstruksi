@extends('layouts.app')

@section('title','Tambah Material Request')

@section('content')

<div class="card shadow">

<div class="card-header">

    <h5 class="mb-0">
        Tambah Material Request
    </h5>

</div>

<div class="card-body">

    <form action="{{ route('material-request.store') }}"
          method="POST">

        @csrf

        <div class="mb-3">

            <label class="form-label">
                Keterangan
            </label>

            <textarea
                name="keterangan"
                class="form-control"
                rows="3"></textarea>

        </div>

        <div class="card">

            <div class="card-header d-flex justify-content-between">

                <span>
                    Detail Material Request
                </span>

                <button
                    type="button"
                    class="btn btn-success btn-sm"
                    id="addRow">

                    <i class="bi bi-plus-circle"></i>
                    Tambah Barang

                </button>

            </div>

            <div class="card-body">

                <table class="table table-bordered">

                    <thead>

                        <tr>
                            <th>Barang</th>
                            <th>Kategori</th>
                            <th width="120">Qty</th>
                            <th>Catatan</th>
                            <th width="80">Aksi</th>
                        </tr>

                    </thead>

                    <tbody id="detailTable">

                    </tbody>

                </table>

            </div>

        </div>

        <div class="mt-3">

            <button
                type="submit"
                class="btn btn-primary">

                <i class="bi bi-save"></i>
                Simpan

            </button>

            <a href="{{ route('material-request.index') }}"
               class="btn btn-secondary">

                Kembali

            </a>

        </div>

    </form>

</div>


</div>

<input type="hidden"
    id="barang-data"
    value='@json($barangs)'>

<input type="hidden"
    id="kategori-data"
    value='@json($kategoris)'>

@endsection

@push('scripts')

<script>

const barangs = JSON.parse(
    document.getElementById('barang-data').value
);

const kategoris = JSON.parse(
    document.getElementById('kategori-data').value
);

/*
|--------------------------------------------------------------------------
| DATALIST BARANG
|--------------------------------------------------------------------------
*/

let barangList = '';

barangs.forEach(function(item){

    barangList += `
        <option value="${item.nama_barang}">
    `;

});

/*
|--------------------------------------------------------------------------
| DATALIST KATEGORI
|--------------------------------------------------------------------------
*/

let kategoriList = '';

kategoris.forEach(function(item){

    kategoriList += `
        <option value="${item.nama_kategori}">
    `;

});

/*
|--------------------------------------------------------------------------
| GENERATE DATALIST
|--------------------------------------------------------------------------
*/

document.body.insertAdjacentHTML(
    'beforeend',
    `
    <datalist id="barangList">
        ${barangList}
    </datalist>

    <datalist id="kategoriList">
        ${kategoriList}
    </datalist>
    `
);

/*
|--------------------------------------------------------------------------
| TAMBAH ROW
|--------------------------------------------------------------------------
*/

document
.getElementById('addRow')
.addEventListener(
'click',
function(){

    let row = `

    <tr>

        <td>

            <input
                type="text"
                name="nama_barang[]"
                class="form-control"
                list="barangList"
                placeholder="Pilih / Ketik Barang"
                required>

        </td>

        <td>

            <input
                type="text"
                name="nama_kategori[]"
                class="form-control"
                list="kategoriList"
                placeholder="Pilih / Ketik Kategori"
                required>

        </td>

        <td>

            <input
                type="number"
                name="qty[]"
                class="form-control"
                min="1"
                required>

        </td>

        <td>

            <input
                type="text"
                name="catatan[]"
                class="form-control">

        </td>

        <td>

            <button
                type="button"
                class="btn btn-danger btn-sm removeRow">

                <i class="bi bi-trash"></i>

            </button>

        </td>

    </tr>

    `;

    document
        .getElementById('detailTable')
        .insertAdjacentHTML(
            'beforeend',
            row
        );

});

/*
|--------------------------------------------------------------------------
| HAPUS ROW
|--------------------------------------------------------------------------
*/

document.addEventListener(
'click',
function(e){

    if(
        e.target.closest('.removeRow')
    ){

        e.target
            .closest('tr')
            .remove();

    }

});

/*
|--------------------------------------------------------------------------
| ROW PERTAMA
|--------------------------------------------------------------------------
*/

document
.getElementById('addRow')
.click();

</script>

@endpush
