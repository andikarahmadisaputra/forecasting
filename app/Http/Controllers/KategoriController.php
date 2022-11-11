<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategoris = Kategori::all();

        return view('kategoris.index', compact('kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kategoris.create');
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
            'kode' => 'string|max:255|nullable',
            'nama' => 'required|unique:kategoris,nama',
            'stok_aman' => 'integer|min:0|nullable',
            'buffer' => 'integer|min:0|nullable',
            'stok_sekarang' => 'integer|min:0|nullable'
        ]);

        $array = $request->only([
            'kode', 'nama', 'stok_aman', 'buffer', 'stok_sekarang'
        ]);
        
        $kategori = Kategori::create($array);
        return redirect()->route('kategoris.index')
            ->with('success_message', 'Berhasil menambah kategori baru');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function show(Kategori $kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function edit(Kategori $kategori)
    {
        if (!$kategori) return redirect()->route('kategoris.index')
            ->with('error_message', 'Kategori dengan id'.$id.' tidak ditemukan');
        
        return view('kategoris.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'kode' => 'string|max:255|nullable',
            'nama' => 'required',
            'stok_aman' => 'integer|min:0|nullable',
            'buffer' => 'integer|min:0|nullable',
            'stok_sekarang' => 'integer|min:0|nullable'
        ]);

        // $cek_kategori = Kategori::where('id', $kategori->id)->first();
        // if($cek_kategori->stok_minimal != '' || $cek_kategori->stok_minimal != 0) {
        //     if($request->stok_aman != '' || $request->stok_aman != 0) {
        //         if($request->buffer != '' || $request->buffer != 0) {
        //             $stok_minimal = $
        //         }
        //     }
        // }

        $kategori->kode = $request->kode;
        $kategori->nama = $request->nama;
        $kategori->stok_aman = $request->stok_aman;
        $kategori->buffer = $request->buffer;
        $kategori->stok_sekarang = $request->stok_sekarang;
        $kategori->save();

        return redirect()->route('kategoris.index')
            ->with('success_message', 'Berhasil mengubah kategori');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kategori $kategori)
    {
        if($kategori->peramalanHeader->count()) {
            return redirect()->route('kategoris.index')
            ->with('error_message', 'Kategori tidak dapat dihapus karena masih dipakai oleh data peramalan header');
        }

        if($kategori->penjualan->count()) {
            return redirect()->route('kategoris.index')
            ->with('error_message', 'Kategori tidak dapat dihapus karena masih dipakai oleh data penjualan');
        }

        $kategori->delete();

        return redirect()->route('kategoris.index')
            ->with('success_message', 'Berhasil hapus kategori');
    }
}
