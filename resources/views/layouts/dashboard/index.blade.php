@extends('layouts.app')

@section('title','Dashboard')

@section('content')

<div class="row">

    <div class="col-md-3">
        <div class="card shadow">
            <div class="card-body">
                <h5>Total Barang</h5>
                <h2>0</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow">
            <div class="card-body">
                <h5>Supplier</h5>
                <h2>0</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow">
            <div class="card-body">
                <h5>Barang Masuk</h5>
                <h2>0</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow">
            <div class="card-body">
                <h5>Barang Keluar</h5>
                <h2>0</h2>
            </div>
        </div>
    </div>

</div>

@endsection