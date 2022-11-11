@extends('adminlte::page')

@section('title', 'Edit Pejualan')

@section('content_header')
    <h1 class="m-0 text-dark">Edit Penjualan</h1>
@stop

@section('content')

    <form action="{{route('penjualans.update', ['id' => $penjualan->id])}}" method="post">
        @method('PUT')
        @csrf
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="form-group">
                        <label for="exampleInputKategori">Kategori</label>
                        <select name="kategori_id" class="form-control">
                            @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" <?php if($penjualan->kategori_id == $kategori->id) { echo "selected"; }?>>{{ $kategori->nama }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputTanggal">Tanggal</label>
                        <input name="tanggal" type="date" class="form-control" value="{{ $penjualan->tanggal ?? old('tanggal') }}">
                    </div>
                        
                    <div class="form-group">
                        <label for="exampleInputJumlah">Jumlah</label>
                        <input type="text" class="form-control @error('jumlah') is-invalid @enderror" id="exampleInputJumlah" placeholder="Jumlah" name="jumlah" value="{{ sprintf('%.0f', $penjualan->jumlah) ?? old('jumlah')}}">
                        @error('jumlah') <span class="text-danger">{{$message}}</span> @enderror
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{route('penjualans.show', ['tahun' => date('Y', strtotime($penjualan->tanggal)), 'bulan' => date('m', strtotime($penjualan->tanggal))])}}" class="btn btn-default">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </div>

@stop
