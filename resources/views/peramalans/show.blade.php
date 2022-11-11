@extends('adminlte::page')

@section('title', 'List Peramalan')

@section('content_header')
    <h1 class="m-0 text-dark">List Peramalan</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <p class="mb-0"><b>{{ strtoupper($peramalanHeader->kategori->nama.' '.getBulan(date('m', strtotime($peramalanHeader->tanggal))).' '.date('Y', strtotime($peramalanHeader->tanggal))) }}</b></p>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                            <tr>
                                <th>Bulan</th>
                                <th>Kategori</th>
                                <th>Hasil</th>
                                <th>Alpha</th>
                                <th>Beta</th>
                                <th>MSE</th>
                                <th>MAD</th>
                                <th>MAPE</th>
                                <th>RMSE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ getBulan(date('m', strtotime($peramalanHeader->tanggal))).' '.date('Y', strtotime($peramalanHeader->tanggal)) }}</td>
                                <td>{{ $peramalanHeader->kategori->nama }}</td>
                                <td>{{ number_format($peramalanHeader->hasil, 2) }}</td>
                                <td>{{ number_format($peramalanHeader->alpha, 1) }}</td>
                                <td>{{ number_format($peramalanHeader->beta, 1) }}</td>
                                <td>{{ number_format($peramalanHeader->mse, 2) }}</td>
                                <td>{{ number_format($peramalanHeader->mad, 2) }}</td>
                                <td>{{ number_format($peramalanHeader->mape, 2) }}</td>
                                <td>{{ number_format($peramalanHeader->rmse, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card-body">
                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Bulan</th>
                                <th>Aktual</th>
                                <th>Level</th>
                                <th>Trend</th>
                                <th>Peramalan</th>
                                <th>SE</th>
                                <th>AD</th>
                                <th>APE</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($peramalanDetails as $key => $detail)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ getBulan(date('m', strtotime($detail->tanggal))).' '.date('Y', strtotime($detail->tanggal)) }}</td>
                                <td>{{ number_format($detail->aktual, 2) }}</td>
                                @if($detail->level != '')
                                <td>{{ number_format($detail->level, 2) }}</td>
                                @endif
                                @if($detail->trend != '')
                                <td>{{ number_format($detail->trend, 2) }}</td>
                                @endif
                                @if($detail->peramalan != '')
                                <td>{{ number_format($detail->peramalan, 2) }}</td>
                                @endif
                                @if($detail->se != '')
                                <td>{{ number_format($detail->se, 2) }}</td>
                                @endif
                                @if($detail->ad != '')
                                <td>{{ number_format($detail->ad, 2) }}</td>
                                @endif
                                @if($detail->ape != '')
                                <td>{{ number_format($detail->ape, 2) }}</td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@stop