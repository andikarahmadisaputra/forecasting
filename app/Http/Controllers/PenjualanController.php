<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cek_kategori = Kategori::all();
        if($cek_kategori->count()) {
            $data = Penjualan::select('tanggal')->orderBy('tanggal', 'asc')->first();
            $tahun_awal = date('Y', strtotime($data->tanggal));
            $tahun_sekarang = date('Y');
            $kategoris = Kategori::select('id', 'nama')->get();

            foreach($kategoris as $kategori) {
                for($i=$tahun_awal;$i<=$tahun_sekarang;$i++) {
                    for($j=1; $j<=12; $j++) {
                        $jumlah = Penjualan::select('kategori_id', 'jumlah')->where('kategori_id', $kategori->id)->whereYear('tanggal', $i)->whereMonth('tanggal', $j)->sum('jumlah');
                        $aktual[$kategori->id][$i][$j] = $jumlah;
                    }
                }
            }
            
            return view('penjualans.index', compact('tahun_awal', 'tahun_sekarang', 'kategoris', 'aktual'));
        } else {
            return redirect()->route('home')
            ->with('error_message', 'Data kategori tidak ada');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategoris = Kategori::select('id', 'nama')->get();

        return view('penjualans.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|integer|min:1',
            'tanggal' => 'required',
            'jumlah' => 'required|integer|min:0'
        ]);

        $array = $request->only([
            'kategori_id', 'tanggal', 'jumlah'
        ]);
        
        $penjualan = Penjualan::create($array);
        return redirect()->route('penjualans.index')
            ->with('success_message', 'Berhasil menambah penjualan baru');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function show($tahun, $bulan)
    {
        $kategoris = Kategori::select('id', 'nama')->get();

        foreach($kategoris as $kategori) {
            $urutan = 1;
            $penjualans = Penjualan::select('id', 'kategori_id', 'tanggal', 'jumlah')->where('kategori_id', $kategori->id)->whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan)->orderBy('tanggal', 'asc')->get();
                foreach($penjualans as $penjualan) {
                    $aktual[$kategori->id][$urutan] = [
                        'id' => $penjualan->id,
                        'tanggal' => $penjualan->tanggal,
                        'jumlah' => $penjualan->jumlah
                    ];
                    $urutan++;
                }
        }

        return view('penjualans.show', compact('kategoris', 'aktual'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kategoris = Kategori::select('id', 'nama')->get();

        $penjualan = Penjualan::select('id', 'kategori_id', 'tanggal', 'jumlah')->where('id', $id)->first();

        return view('penjualans.edit', compact('kategoris', 'penjualan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_id' => 'required|integer|min:1',
            'tanggal' => 'required',
            'jumlah' => 'required|integer|min:0'
        ]);

        $penjualan = Penjualan::find($id);
        $penjualan->kategori_id = $request->kategori_id;
        $penjualan->tanggal = $request->tanggal;
        $penjualan->jumlah = $request->jumlah;
        $penjualan->save();

        return redirect()->route('penjualans.index')
            ->with('success_message', 'Berhasil mengubah penjualan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $penjualan = Penjualan::find($id);
        $penjualan->delete();

        return redirect()->route('penjualans.index')
            ->with('success_message', 'Berhasil hapus penjualan');
    }
}
