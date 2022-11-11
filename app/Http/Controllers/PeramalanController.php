<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\PeramalanHeader;
use App\Models\PeramalanDetail;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeramalanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cek_penjualan = Penjualan::all();
        if($cek_penjualan->count()) {
            $peramalanHeaders = PeramalanHeader::all();
            return view('peramalans.index', compact('peramalanHeaders'));
        } else {
            return redirect()->route('home')
                ->with('error_message', 'Data penjualan tidak ada');
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
        return view('peramalans.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kategori_id = request('kategori_id');

        $cek_penjualan = Penjualan::select('kategori_id')->where('kategori_id', $kategori_id)->get();
        if($cek_penjualan->count()) {

            // $data_awal = Penjualan::select('tanggal')->where('kategori_id', $kategori_id)
            //                     ->orderBy('tanggal', 'asc')->first();
            // $tahun_awal = date('Y', strtotime($data_awal->tanggal));
            // $bulan_awal = date('m', strtotime($data_awal->tanggal));
            $data_akhir = Penjualan::select('tanggal')->where('kategori_id', $kategori_id)
                                ->orderBy('tanggal', 'desc')->first();
            $tahun_akhir = date('Y', strtotime($data_akhir->tanggal));
            $bulan_akhir = date('m', strtotime($data_akhir->tanggal));
            
            $penjualans = Penjualan::select('id', 'kategori_id', 'tanggal', 'jumlah')->where('kategori_id', $kategori_id)->orderBy('tanggal', 'asc')->get();

            $cekData = [];
            $urutan = 1;
            $count_data = 0;
            $sum_se = 0;
            $sum_ad = 0;
            $sum_ape = 0;
            $rse = 0;

            //mengelompokkan dan menggabungkan data berdasarkan tahun dan bulan
            foreach ($penjualans as $penjualan) {
                // mengambil tahun penjualan
                $tahun = date('Y', strtotime($penjualan->tanggal));
                // mengambil bulan penjualan
                $bulan = date('m', strtotime($penjualan->tanggal));

                // cek tahun dan bulan sudah ada atau belum
                if(array_key_exists($tahun.$bulan, $cekData)){
                    // membuat variabel data sudah ada untuk tampungan sementara
                    $dataSudahAda = $cekData[$tahun.$bulan];
                    // menjumlahkan data penjualan ke variabel sementara data yang sudah ada
                    $dataSudahAda['aktual'] += $penjualan->jumlah;
                    // data tampungan sementara dimasukkan ke variabel cek data
                    $cekData[$tahun.$bulan] = $dataSudahAda;
                } else {
                    // data yang belum ada ditambahkan ke variabel cek data
                    $cekData[$tahun.$bulan] =
                    [
                        'urutan' => $urutan,
                        'tahun' => $tahun,
                        'bulan' => $bulan,
                        'aktual' => (int) $penjualan->jumlah
                    ];
                    $urutan++;
                }
            }


            for ($i=0; $i <= 10; $i++) {
                $alpha = $i/10;
                for ($j=0; $j <= 10; $j++) { 
                    $beta = $j/10;
                    // data yang sudah dikelompokkan dimasukkan ke variabel data peramalan untuk diramalkan
                    foreach($cekData as $master) {
                        if($master['urutan'] == 1) {
                            $data[$master['urutan']] =
                            [
                                'urutan' => $master['urutan'],
                                'tahun' => $master['tahun'],
                                'bulan' => $master['bulan'],
                                'aktual' => (int) $master['aktual'],
                                'level' => '',
                                'trend' => '',
                                'peramalan' => '',
                                'se' => '',
                                'ad' => '',
                                'ape' => ''
                            ];
                        } elseif($master['urutan'] == 2) {
                            $data[$master['urutan']] =
                            [
                                'urutan' => $master['urutan'],
                                'tahun' => $master['tahun'],
                                'bulan' => $master['bulan'],
                                'aktual' => (int) $master['aktual'],
                                'level' => (int) $master['aktual'],
                                'trend' => (int) $master['aktual'] - $data[$master['urutan']-1]['aktual'],
                                'peramalan' => '',
                                'se' => '',
                                'ad' => '',
                                'ape' => ''
                            ];
                        } else {
                            $aktualSekarang = $master['aktual'];
                            $levelSebelumnya = $data[$master['urutan']-1]['level'];
                            $trendSebelumnya = $data[$master['urutan']-1]['trend'];
                            $levelSekarang = $alpha*$aktualSekarang + (1-$alpha)*($levelSebelumnya+$trendSebelumnya);
                            $trendSekarang = $beta*($levelSekarang-$levelSebelumnya) + (1-$beta)*$trendSebelumnya;
                            $peramalanSekarang = $levelSebelumnya + $trendSebelumnya;
                            $se = $aktualSekarang - $peramalanSekarang;
                            $ad = abs($se);
                            $ape = $ad/$aktualSekarang*100;
                            $data[$master['urutan']] =
                            [
                                'urutan' => $master['urutan'],
                                'tahun' => $master['tahun'],
                                'bulan' => $master['bulan'],
                                'aktual' => (int) $aktualSekarang,
                                'level' => (int) $levelSekarang,
                                'trend' => (int) $trendSekarang,
                                'peramalan' => (int) $peramalanSekarang,
                                'se' => (int) $se,
                                'ad' => (int) $ad,
                                'ape' => (int) $ape
                            ];

                            $count_data += 1;
                            $sum_se += $se;
                            $sum_ad += $ad;
                            $sum_ape += $ape;
                            $rse += pow($se, 2);
                        }   
                    }

                    if($count_data <= 2) {
                        return redirect()->route('home')
                        ->with('error_message', 'Data penjualan kurang');
                    }
                    
                    $tanggal_peramalan = Carbon::createFromFormat('Y-m-d', $data_akhir->tanggal)->addMonth();
                    $peramalan = $data[$urutan-1]['level'] + $data[$urutan-1]['trend'];
                    $mse = $sum_se/$count_data;
                    $mad = $sum_ad/$count_data;
                    $mape = $sum_ape/$count_data;
                    $rmse = sqrt($rse/$count_data);

                    if(isset($dataPeramalan)) {
                        if ($dataPeramalan['rmse'] > $rmse) {
                            $dataPeramalan = [
                                'tanggal' => $tanggal_peramalan->format('Y-m-d'),
                                'kategori_id' => $kategori_id,
                                'hasil' => $peramalan,
                                'alpha' => $alpha,
                                'beta' => $beta,
                                'mse' => $mse,
                                'mad' => $mad,
                                'mape' => $mape,
                                'rmse' => $rmse
                            ]; 
                        }    
                    } else {
                        $dataPeramalan = [
                            'tanggal' => $tanggal_peramalan->format('Y-m-d'),
                            'kategori_id' => $kategori_id,
                            'hasil' => $peramalan,
                            'alpha' => $alpha,
                            'beta' => $beta,
                            'mse' => $mse,
                            'mad' => $mad,
                            'mape' => $mape,
                            'rmse' => $rmse
                        ]; 
                    }

                    $count_data = 0;
                    $sum_se = 0;
                    $sum_ad = 0;
                    $sum_ape = 0;
                    $rse = 0;
                    
                }
            }

            \DB::beginTransaction();
            try {
                $peramalanHeader = new PeramalanHeader;
                $peramalanHeader->tanggal = $dataPeramalan['tanggal'];
                $peramalanHeader->kategori_id = $dataPeramalan['kategori_id'];
                $peramalanHeader->hasil = sprintf("%.2f", $dataPeramalan['hasil']);
                $peramalanHeader->alpha = sprintf("%.2f", $dataPeramalan['alpha']);
                $peramalanHeader->beta = sprintf("%.2f", $dataPeramalan['beta']);
                $peramalanHeader->mse = sprintf("%.2f", $dataPeramalan['mse']);
                $peramalanHeader->mad = sprintf("%.2f", $dataPeramalan['mad']);
                $peramalanHeader->mape = sprintf("%.2f", $dataPeramalan['mape']);
                $peramalanHeader->rmse = sprintf("%.2f", $dataPeramalan['rmse']);
                $peramalanHeader->save();

                $kategori = Kategori::where('id', $dataPeramalan['kategori_id'])->first();
                if($kategori->stok_aman != '' || $kategori->stok_aman != 0) {
                    if($kategori->buffer != '' || $kategori->buffer != 0) {
                        $jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $bulan_akhir, $tahun_akhir);
                        $stok_minimal = $kategori->stok_aman / $jumlah_hari * $dataPeramalan['hasil'];
                        $stok_maksimal = ($kategori->stok_aman + $kategori->buffer) / $jumlah_hari * $dataPeramalan['hasil'];
                        $inputKategori = Kategori::find($dataPeramalan['kategori_id']);
                        $inputKategori->stok_minimal = $stok_minimal;
                        $inputKategori->stok_maksimal = $stok_maksimal;
                        $inputKategori->save();
                    } else {
                        $jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $bulan_akhir, $tahun_akhir);
                        $stok_minimal = $kategori->stok_aman / $jumlah_hari * $dataPeramalan['hasil'];
                        $inputKategori = Kategori::find($dataPeramalan['kategori_id']);
                        $inputKategori->stok_minimal = $stok_minimal;
                        $inputKategori->stok_maksimal = $stok_minimal;
                        $inputKategori->buffer = 0;
                        $inputKategori->save();
                    }
                } else {
                    if($kategori->buffer != '' || $kategori->buffer != 0) {
                        $jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $bulan_akhir, $tahun_akhir);
                        $stok_aman_default = 21;
                        $stok_minimal = $stok_aman_default / $jumlah_hari * $dataPeramalan['hasil'];
                        $stok_maksimal = ($stok_aman_default + $kategori->buffer) / $jumlah_hari * $dataPeramalan['hasil'];
                        $inputKategori = Kategori::find($dataPeramalan['kategori_id']);
                        $inputKategori->stok_aman = $stok_aman_default;
                        $inputKategori->stok_minimal = $stok_minimal;
                        $inputKategori->stok_maksimal = $stok_maksimal;
                        $inputKategori->save();
                    } else {
                        $jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $bulan_akhir, $tahun_akhir);
                        $stok_aman_default = 21;
                        $stok_minimal = $stok_aman_default / $jumlah_hari * $dataPeramalan['hasil'];
                        $inputKategori = Kategori::find($dataPeramalan['kategori_id']);
                        $inputKategori->stok_aman = $stok_aman_default;
                        $inputKategori->stok_minimal = $stok_minimal;
                        $inputKategori->stok_maksimal = $stok_minimal;
                        $inputKategori->buffer = 0;
                        $inputKategori->save();
                    }
                }
            
                foreach($cekData as $master) {
                    if($master['urutan'] == 1) {
                        $data[$master['urutan']] =
                        [
                            'urutan' => $master['urutan'],
                            'tahun' => $master['tahun'],
                            'bulan' => $master['bulan'],
                            'aktual' => (int) $master['aktual'],
                            'level' => '',
                            'trend' => '',
                            'peramalan' => '',
                            'se' => '',
                            'ad' => '',
                            'ape' => ''
                        ];

                        $peramalanDetail = new PeramalanDetail;
                        $peramalanDetail->peramalan_header_id = $peramalanHeader->id;
                        $peramalanDetail->tanggal = $master['tahun'].'-'.$master['bulan'].'-01';
                        $peramalanDetail->aktual = sprintf("%.2f", $master['aktual']);
                        $peramalanDetail->save();
                        
                    } elseif($master['urutan'] == 2) {
                        $trend = (int) $master['aktual'] - $data[$master['urutan']-1]['aktual'];
                        $data[$master['urutan']] =
                        [
                            'urutan' => $master['urutan'],
                            'tahun' => $master['tahun'],
                            'bulan' => $master['bulan'],
                            'aktual' => (int) $master['aktual'],
                            'level' => (int) $master['aktual'],
                            'trend' => $trend,
                            'peramalan' => '',
                            'se' => '',
                            'ad' => '',
                            'ape' => ''
                        ];

                        $peramalanDetail = new PeramalanDetail;
                        $peramalanDetail->peramalan_header_id = $peramalanHeader->id;
                        $peramalanDetail->tanggal = $master['tahun'].'-'.$master['bulan'].'-01';
                        $peramalanDetail->aktual = sprintf("%.2f", $master['aktual']);
                        $peramalanDetail->level = sprintf("%.2f", $master['aktual']);
                        $peramalanDetail->trend = sprintf("%.2f", $trend);
                        $peramalanDetail->save();

                    } else {
                        $aktualSekarang = $master['aktual'];
                        $levelSebelumnya = $data[$master['urutan']-1]['level'];
                        $trendSebelumnya = $data[$master['urutan']-1]['trend'];
                        $levelSekarang = $dataPeramalan['alpha']*$aktualSekarang + (1-$dataPeramalan['alpha'])*($levelSebelumnya+$trendSebelumnya);
                        $trendSekarang = $dataPeramalan['beta']*($levelSekarang-$levelSebelumnya) + (1-$dataPeramalan['beta'])*$trendSebelumnya;
                        $peramalanSekarang = $levelSebelumnya + $trendSebelumnya;
                        $se = $aktualSekarang - $peramalanSekarang;
                        $ad = abs($se);
                        $ape = $ad/$aktualSekarang*100;
                        $data[$master['urutan']] =
                        [
                            'urutan' => $master['urutan'],
                            'tahun' => $master['tahun'],
                            'bulan' => $master['bulan'],
                            'aktual' => (int) $aktualSekarang,
                            'level' => (int) $levelSekarang,
                            'trend' => (int) $trendSekarang,
                            'peramalan' => (int) $peramalanSekarang,
                            'se' => (int) $se,
                            'ad' => (int) $ad,
                            'ape' => (int) $ape
                        ];

                        $peramalanDetail = new PeramalanDetail;
                        $peramalanDetail->peramalan_header_id = $peramalanHeader->id;
                        $peramalanDetail->tanggal = $master['tahun'].'-'.$master['bulan'].'-01';
                        $peramalanDetail->aktual = sprintf("%.2f", $aktualSekarang);
                        $peramalanDetail->level = sprintf("%.2f", $levelSekarang);
                        $peramalanDetail->trend = sprintf("%.2f", $trendSekarang);
                        $peramalanDetail->peramalan = sprintf("%.2f", $peramalanSekarang);
                        $peramalanDetail->se = sprintf("%.2f", $se);
                        $peramalanDetail->ad = sprintf("%.2f", $ad);
                        $peramalanDetail->ape = sprintf("%.2f", $ape);
                        $peramalanDetail->save();
                    }   
                }
            } catch (\Exception $e) {
                \DB::rollBack();
                dd($e->getMessage().$e->getLine());
                return redirect()->back();
            }
            \DB::commit();

            return redirect()->route('peramalans.index')
                ->with('success_message', 'Berhasil menambah peramalan baru');
        } else {
            return redirect()->route('peramalans.index')
                ->with('error_message', 'Tidak ada data penjualan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($peramalan)
    {
        $peramalanHeader = PeramalanHeader::select('id', 'tanggal', 'kategori_id', 'hasil', 'alpha', 'beta', 'mse', 'mad', 'mape', 'rmse')->where('id', $peramalan)->first();
        $peramalanDetails = PeramalanDetail::where('peramalan_header_id', $peramalan)->orderBy('tanggal', 'asc')->get();

        return view('peramalans.show', compact('peramalanHeader', 'peramalanDetails'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($peramalan)
    {
        \DB::beginTransaction();
        try {
            $peramalanHeader = PeramalanHeader::find($peramalan);
            $peramalanHeader->delete();

            $peramalanDetail = PeramalanDetail::where('peramalan_header_id', $peramalan);
            $peramalanDetail->delete();

        } catch (\Exception $e) {
            \DB::rollBack();
            dd($e->getMessage().$e->getLine());
            return redirect()->back();
        }
        \DB::commit();

        return redirect()->route('peramalans.index')
            ->with('success_message', 'Berhasil hapus peramalan');
    }
}
