@extends('adminlte::page')

@section('title', 'Tambah Pejualan')

@section('content_header')
    <h1 class="m-0 text-dark">Tambah Penjualan</h1>
@stop

@section('content')

    <form action="{{route('penjualans.store')}}" method="post">
        @csrf
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="form-group">
                        <label for="exampleInputKategori">Kategori</label>
                        <select name="kategori_id" class="form-control">
                            @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputTanggal">Tanggal</label>
                        <input name="tanggal" type="date" class="datepicker-here form-control"/>
                    </div>
                        
                    <div class="form-group">
                        <label for="exampleInputJumlah">Jumlah</label>
                        <input type="text" class="form-control @error('jumlah') is-invalid @enderror" id="exampleInputJumlah" placeholder="Jumlah" name="jumlah" value="{{old('jumlah')}}">
                        @error('jumlah') <span class="text-danger">{{$message}}</span> @enderror
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
