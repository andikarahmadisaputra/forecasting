@extends('adminlte::page')

@section('title', 'Forecast')

@section('content_header')
    <h1 class="m-0 text-dark">Sistem Pendukung Keputusan Untuk Peramalan Penjualan Menggunakan Metode Double Exponential Smoothing</h1>
    <h1 class="m-0 text-dark">(Studi Kasus di Minimarket Zenamrt)</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <p class="mb-0"><b>Tentang Aplikasi</b></p>
                </div>
                <div class="card-body">
                    <p class="mb-0">Aplikasi Peramalan ini dibuat dan dikembangkan oleh Andika Rahmadi Saputra sebagai syarat mengikuti sidang skripsi.</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <p class="mb-0"><b>Panduan Penggunaan</b></p>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Kategori</h5><br>
                    <p class="mb-0">1. Anda tidak diperbolehkan membuka menu lain apabila master kategori belum terisi.</p>
                    <p class="mb-0">2. Untuk dapat menggunakan aplikasi ini, silahkan tambahkan data kategori dengan cara klik tombol <b>Tambah</b> di menu <b>Kategori</b>.</p>
                    <p class="mb-0">3. Anda dapat <b>menambah</b>, <b>mengedit</b> dan <b>menghapus</b> data kategori pada menu ini.</p>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Penjualan</h5><br>
                    <p class="mb-0">1. Anda dapat menambahkan data penjualan per kategori di menu ini.</p>
                    <p class="mb-0">2. Data penjualan yang harus ditambahkan minimal 3 bulan berturut-turut untuk dapat diramalkan.</p>
                    <p class="mb-0">3. Anda dapat <b>menambah</b>, <b>mengedit</b> dan <b>menghapus</b> data penjualan pada menu ini.</p>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Peramalan</h5><br>
                    <p class="mb-0">1. Anda bisa melakukan proses peramalan dengan cara memilih salah satu kategori kemudian meng klik tombol<b>Proses</b>.</p>
                    <p class="mb-0">2. Setelah proses selesai, program akan menampilkan hasil peramalan.</p>
                    <p class="mb-0">3. Anda dapat <b>menambah</b> dan <b>menghapus</b> hasil peramalan pada menu ini.</p>
            </div>
        </div>
    </div>
@stop
