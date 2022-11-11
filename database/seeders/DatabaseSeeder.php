<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Penjualan;
use App\Models\User;
use App\Models\Kategori;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name' => 'Andika Rahmadi Saputra',
            'email' => 'andikars811@gmail.com',
            'password' => bcrypt('P@ssw0rd')
        ]);

        Kategori::create([
            'nama' => 'Penjualan'
        ]);

        Penjualan::create([
            'kategori_id' => 1,
            'tanggal' => '2021-02-01',
            'jumlah' => '138077266'
        ]);

        Penjualan::create([
            'kategori_id' => 1,
            'tanggal' => '2021-03-01',
            'jumlah' => '128948630'
        ]);

        Penjualan::create([
            'kategori_id' => 1,
            'tanggal' => '2021-04-01',
            'jumlah' => '130193895'
        ]);

        Penjualan::create([
            'kategori_id' => 1,
            'tanggal' => '2021-05-01',
            'jumlah' => '124168734'
        ]);

        Penjualan::create([
            'kategori_id' => 1,
            'tanggal' => '2021-06-01',
            'jumlah' => '86526225'
        ]);

        Penjualan::create([
            'kategori_id' => 1,
            'tanggal' => '2021-07-01',
            'jumlah' => '78629103'
        ]);

        Penjualan::create([
            'kategori_id' => 1,
            'tanggal' => '2021-08-01',
            'jumlah' => '83319286'
        ]);

        Penjualan::create([
            'kategori_id' => 1,
            'tanggal' => '2021-09-01',
            'jumlah' => '84289378'
        ]);

        Penjualan::create([
            'kategori_id' => 1,
            'tanggal' => '2021-10-01',
            'jumlah' => '103679670'
        ]);

        Penjualan::create([
            'kategori_id' => 1,
            'tanggal' => '2021-11-01',
            'jumlah' => '92779251'
        ]);

        Penjualan::create([
            'kategori_id' => 1,
            'tanggal' => '2021-12-01',
            'jumlah' => '87322498'
        ]);

        Penjualan::create([
            'kategori_id' => 1,
            'tanggal' => '2022-01-01',
            'jumlah' => '106161875'
        ]);

        Penjualan::create([
            'kategori_id' => 1,
            'tanggal' => '2022-02-01',
            'jumlah' => '96051600'
        ]);

        Penjualan::create([
            'kategori_id' => 1,
            'tanggal' => '2022-03-01',
            'jumlah' => '134615354'
        ]);

        Penjualan::create([
            'kategori_id' => 1,
            'tanggal' => '2022-04-01',
            'jumlah' => '164150748'
        ]);

        Penjualan::create([
            'kategori_id' => 1,
            'tanggal' => '2022-05-01',
            'jumlah' => '94144952'
        ]);

        Penjualan::create([
            'kategori_id' => 1,
            'tanggal' => '2022-06-01',
            'jumlah' => '104118786'
        ]);

        Penjualan::create([
            'kategori_id' => 1,
            'tanggal' => '2022-07-01',
            'jumlah' => '122564572'
        ]);
    }
}
