@extends('adminlte::page')

@section('title', 'List Detail Penjualan')

@section('content_header')
    <h1 class="m-0 text-dark">List Detail Penjualan</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @foreach($kategoris as $kategori)
            <div class="card">
                <div class="card-header">
                    <p class="mb-0"><b>{{ strtoupper($kategori->nama)}}</b></p>
                </div>
                <div class="card-body">

                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kategori</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Opsi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(array_key_exists($kategori->id, $aktual))
                        @for($i=1;$i<=count($aktual[$kategori->id]);$i++)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $kategori->nama }}</td>
                                <td>{{ $aktual[$kategori->id][$i]['tanggal'] }}</td>
                                <td>{{ number_format($aktual[$kategori->id][$i]['jumlah'], 2) }}</td>
                                <td>
                                    <a href="{{route('penjualans.edit', ['id' => $aktual[$kategori->id][$i]['id']]) }}" class="btn btn-primary btn-xs">
                                        Edit
                                    </a>
                                    <a href="{{route('penjualans.destroy', ['id' => $aktual[$kategori->id][$i]['id']]) }}" onclick="notificationBeforeDelete(event, this)" class="btn btn-danger btn-xs">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        @endfor
                        @endif
                        </tbody>
                    </table>

                </div>
            </div>
            @endforeach
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