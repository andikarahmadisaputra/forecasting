@extends('adminlte::page')

@section('title', 'Tambah Kategori')

@section('content_header')
    <h1 class="m-0 text-dark">Tambah Kategori</h1>
@stop

@section('content')
    <form action="{{route('kategoris.store')}}" method="post">
        @csrf
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="form-group">
                        <label for="exampleInputKode">Kode</label>
                        <input type="text" class="form-control @error('kode') is-invalid @enderror" id="exampleInputKode" placeholder="Kode" name="kode" value="{{old('kode')}}">
                        @error('kode') <span class="text-danger">{{$message}}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleInputNama">Nama</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="exampleInputNama" placeholder="Nama" name="nama" value="{{old('nama')}}">
                        @error('nama') <span class="text-danger">{{$message}}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleInputStokAman">Stok Aman (hari)</label>
                        <input type="text" class="form-control @error('stok_aman') is-invalid @enderror" id="exampleInputStokAman" placeholder="Stok Aman (hari)" name="stok_aman" value="{{old('stok_aman')}}">
                        @error('stok_aman') <span class="text-danger">{{$message}}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleInputBuffer">Buffer</label>
                        <input type="text" class="form-control @error('buffer') is-invalid @enderror" id="exampleInputBuffer" placeholder="Buffer" name="buffer" value="{{old('buffer')}}">
                        @error('buffer') <span class="text-danger">{{$message}}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleInputStokSekarang">Stok Sekarang</label>
                        <input type="text" class="form-control @error('stok_sekarang') is-invalid @enderror" id="exampleInputStokSekarang" placeholder="Stok Sekarang" name="stok_sekarang" value="{{old('stok_sekarang')}}">
                        @error('stok_sekarang') <span class="text-danger">{{$message}}</span> @enderror
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{route('kategoris.index')}}" class="btn btn-default">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop