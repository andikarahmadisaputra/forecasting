@extends('adminlte::page')

@section('title', 'List Peramalan')

@section('content_header')
    <h1 class="m-0 text-dark">List Peramalan</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <a href="{{route('peramalans.create')}}" class="btn btn-primary mb-2">
                        Tambah
                    </a>

                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Bulan</th>
                            <th>Kategori</th>
                            <th>Hasil</th>
                            <th>Alpha</th>
                            <th>Beta</th>
                            <th>MSE</th>
                            <th>MAD</th>
                            <th>MAPE</th>
                            <th>RMSE</th>
                            <th>Opsi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($peramalanHeaders as $key => $peramalanHeader)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ getBulan(date('m', strtotime($peramalanHeader->tanggal))).' '.date('Y', strtotime($peramalanHeader->tanggal)) }}</td>
                                <td>{{ $peramalanHeader->kategori->nama }}</td>
                                <td>{{ number_format($peramalanHeader->hasil, 2) }}</td>
                                <td>{{ number_format($peramalanHeader->alpha, 1) }}</td>
                                <td>{{ number_format($peramalanHeader->beta, 1) }}</td>
                                <td>{{ number_format($peramalanHeader->mse, 2) }}</td>
                                <td>{{ number_format($peramalanHeader->mad, 2) }}</td>
                                <td>{{ number_format($peramalanHeader->mape, 2) }}</td>
                                <td>{{ number_format($peramalanHeader->rmse, 2) }}</td>
                                <td>
                                    <a href="{{route('peramalans.show', ['peramalan' => $peramalanHeader->id])}}" class="btn btn-primary btn-xs">
                                        Show
                                    </a>
                                    <a href="{{route('peramalans.destroy', ['peramalan' => $peramalanHeader->id])}}" onclick="notificationBeforeDelete(event, this)" class="btn btn-danger btn-xs">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
    <form action="" id="delete-form" method="post">
        @method('delete')
        @csrf
    </form>
    <script>
        $('#example2').DataTable({
            "responsive": true,
        });

        function notificationBeforeDelete(event, el) {
            event.preventDefault();
            if (confirm('Apakah anda yakin akan menghapus data ? ')) {
                $("#delete-form").attr('action', $(el).attr('href'));
                $("#delete-form").submit();
            }
        }

    </script>
@endpush