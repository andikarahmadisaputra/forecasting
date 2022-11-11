@extends('adminlte::page')

@section('title', 'List Penjualan')

@section('content_header')
    <h1 class="m-0 text-dark">List Penjualan</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <a href="{{route('penjualans.create')}}" class="btn btn-primary mb-2">
                        Tambah
                    </a>

                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Tanggal</th>
                            @foreach($kategoris as $kategori)
                            <th>{{ strtoupper($kategori->nama) }}</th>
                            @endforeach
                            <th>Opsi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $no = 0; ?>
                        @for($i=$tahun_awal;$i<=$tahun_sekarang;$i++)
                            @for($j=1;$j<=12;$j++)
                            <tr>
                                <?php $no++; ?>
                                <td>{{ $no }}</td>
                                <td>{{ getBulan($j).' '.$i }}</td>
                                @foreach($kategoris as $kategori)
                                <td>{{ number_format($aktual[$kategori->id][$i][$j], 2) }}</td>
                                @endforeach
                                <td>
                                    <a href="{{ route('penjualans.show', ['tahun' => $i, 'bulan' => $j]) }}" class="btn btn-primary btn-xs">
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                            @endfor
                        @endfor
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@stop