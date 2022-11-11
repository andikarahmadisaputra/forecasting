@extends('adminlte::page')

@section('title', 'List Kategori')

@section('content_header')
    <h1 class="m-0 text-dark">List Kategori</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <a href="{{route('kategoris.create')}}" class="btn btn-primary mb-2">
                        Tambah
                    </a>

                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Stok Minimal</th>
                            <th>Stok Maksimal</th>
                            <th>Stok Aman (hari)</th>
                            <th>Buffer (hari)</th>
                            <th>Stok Sekarang</th>
                            <th>Opsi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($kategoris as $key => $kategori)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$kategori->kode}}</td>
                                <td>{{$kategori->nama}}</td>
                                <td>{{number_format($kategori->stok_minimal)}}</td>
                                <td>{{number_format($kategori->stok_maksimal)}}</td>
                                <td>{{$kategori->stok_aman}}</td>
                                <td>{{$kategori->buffer}}</td>
                                <td>{{$kategori->stok_sekarang}}</td>
                                <td>
                                    <a href="{{route('kategoris.edit', $kategori)}}" class="btn btn-primary btn-xs">
                                        Edit
                                    </a>
                                    <a href="{{route('kategoris.destroy', $kategori)}}" onclick="notificationBeforeDelete(event, this)" class="btn btn-danger btn-xs">
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