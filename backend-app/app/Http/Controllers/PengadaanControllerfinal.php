<?php

namespace App\Http\Controllers;

use App\Http\Resources\PenerimaanObatResource;
use App\Http\Resources\PengadaanResource;
use App\Imports\SaldoAwalImport;
use App\Models\Databarang;
use App\Models\DetailPesaanModel;
use App\Models\PemesananModel;
use App\Models\RiwatbarangMedis;
use App\Models\SaldoAwalModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class PengadaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $listranap = Databarang::all();
        $response = [
            'success' => true,
            'message' => 'data list nomer rawat',
            'total' => $listranap->count(),
            'data' => PengadaanResource::collection($listranap),
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Display a listing of the resource.
     */
    public function pemesanan(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required|max:600',
        ]);
        if ($validator->fails()) {
            $response = [
                'success' => 'false',
                'message' => $validator->errors(),
                'data' => '',
            ];
            return response()->json($response, Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            $tanggalmulai = Carbon::parse($request->tanggal_mulai)->format('Y-m-d');
            $tanggalselesai = Carbon::parse($request->tanggal_selesai)->format('Y-m-d');

            // $penerimaan = DetailPesaanModel::join('pemesanan', 'detailpesan.no_faktur', '=', 'pemesanan.no_faktur')
            //     ->join('riwayat_barang_medis', 'detailpesan.kode_brng', '=', 'riwayat_barang_medis.kode_brng')
            //     ->where('pemesanan.tgl_pesan', '>=', $tanggalmulai)
            //     ->where('pemesanan.tgl_pesan', '<=', $tanggalselesai)
            //     ->select('detailpesan.kode_brng', DB::raw('SUM(detailpesan.jumlah) as jumlah'), DB::raw('SUM(detailpesan.total) as total'))

            //     ->groupBy('detailpesan.kode_brng')
            //     ->get();

            // $penerimaan = DetailPesaanModel::join('pemesanan', 'detailpesan.no_faktur', '=', 'pemesanan.no_faktur')
            //     ->join('riwayat_barang_medis', 'detailpesan.kode_brng', '=', 'riwayat_barang_medis.kode_brng')
            //     ->where('pemesanan.tgl_pesan', '>=', $tanggalmulai)
            //     ->where('pemesanan.tgl_pesan', '<=', $tanggalselesai)
            //     ->select('detailpesan.kode_brng', DB::raw('SUM(detailpesan.jumlah) as jumlah'), DB::raw('SUM(detailpesan.total) as total'))

            //     ->groupBy('detailpesan.kode_brng')
            //     ->get();

            $data = PemesananModel::where('pemesanan.tgl_pesan', '>=', $tanggalmulai)
                ->where('pemesanan.tgl_pesan', '<=', $tanggalselesai)->pluck('no_faktur');
            $penerimaan = DetailPesaanModel::whereIn('no_faktur', $data)
                ->get();


            $retur_mutasi = RiwatbarangMedis::where('status', 'Hapus')
                ->where('tanggal', '>=', $tanggalmulai)
                ->where('tanggal', '<=', $tanggalselesai)
                ->select('kode_brng', DB::raw('SUM(masuk) as total_keluar'))
                ->groupBy('kode_brng')
                ->get();

            $pengeluaran = RiwatbarangMedis::where('status', 'Simpan')
                ->where('tanggal', '>=', $tanggalmulai)
                ->where('tanggal', '<=', $tanggalselesai)
                ->select('kode_brng', DB::raw('SUM(keluar) as total_keluar'))
                ->groupBy('kode_brng')
                ->get();

            $response = [
                'success' => 'true',
                'message' => 'data join',
                'count_data_penerimaan' => $penerimaan->count(),
                'data_penerimaan' =>  $penerimaan,
                // 'count_data_penerimaan' => $retur_mutasi->count(),
                // 'data_penerimaan' =>  $retur_mutasi,
                // 'count_data_penerimaan' => $pengeluaran->count(),
                // 'data_penerimaan' =>  $pengeluaran
            ];
            return response()->json($response, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Show the form for creating a new resource.
     */

    public function pulldata(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            // 'file' => 'required|mimes:xlsx,xls',
            'nama_bulan' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required|max:600',
        ]);
        if ($validator->fails()) {
            $response = [
                'success' => 'false',
                'message' => $validator->errors(),
                'data' => '',
            ];
            return response()->json($response, Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {
        
            $datawal = SaldoAwalModel::where('nama_bulan',$request->nama_bulan)
            ->join('databarang', 'ext_saldo_awal.kode_brng', '=', 'databarang.kode_brng')
            ->join('jenis', 'databarang.kdjns', '=', 'jenis.kdjns')
            ->select(
                'ext_saldo_awal.kode_brng',
                'databarang.nama_brng',
                'jenis.nama as jenisbarang',
                'ext_saldo_awal.qty as qty_saldo_awal',
                'ext_saldo_awal.harsat as harsat_saldo_awal',
                'ext_saldo_awal.nilai as nilai_saldo_awal',
            )
            ->groupBy(
                'ext_saldo_awal.kode_brng',
                'databarang.nama_brng',
                'jenis.nama',
                'ext_saldo_awal.qty',
                'ext_saldo_awal.nilai',
                'ext_saldo_awal.harsat'
            )
            ->get();

            $datapenerimaan = SaldoAwalModel::join('detailpesan', 'ext_saldo_awal.kode_brng', '=', 'detailpesan.kode_brng')
            ->join('pemesanan', 'detailpesan.no_faktur', '=', 'pemesanan.no_faktur')
            ->join('databarang', 'ext_saldo_awal.kode_brng', '=', 'databarang.kode_brng')
            ->join('jenis', 'databarang.kdjns', '=', 'jenis.kdjns')
            ->where('pemesanan.tgl_pesan', '>=', $request->tanggal_mulai)
            ->where('pemesanan.tgl_pesan', '<=', $request->tanggal_selesai)
            ->select(
                'ext_saldo_awal.kode_brng',
                'databarang.nama_brng',
                'jenis.nama',
                DB::raw('SUM(detailpesan.jumlah) as qty_penerimaan'),
                DB::raw('SUM(detailpesan.total) as total_penerimaan'),
            )
            ->groupBy(
                'ext_saldo_awal.kode_brng',
                'databarang.nama_brng',
                'jenis.nama',
                'ext_saldo_awal.qty',
                'ext_saldo_awal.nilai',
                'ext_saldo_awal.harsat'
            )
            ->get();

            $dataretur = SaldoAwalModel::join('riwayat_barang_medis as retur', 'ext_saldo_awal.kode_brng', '=', 'retur.kode_brng')
            //retur
            ->join('databarang', 'ext_saldo_awal.kode_brng', '=', 'databarang.kode_brng')
            ->join('jenis', 'databarang.kdjns', '=', 'jenis.kdjns')
            ->where('retur.tanggal', '>=',  $request->tanggal_mulai)
            ->where('retur.tanggal', '<=',  $request->tanggal_selesai)
            ->where('retur.status', 'Hapus')
            ->select(
                'ext_saldo_awal.kode_brng',
                'databarang.nama_brng',
                'jenis.nama as jenisbarang',
                DB::raw('SUM(retur.masuk) as qty_retur'),
            )
            ->groupBy(
                'ext_saldo_awal.kode_brng',
                'databarang.nama_brng',
                'jenis.nama',
                'ext_saldo_awal.qty',
                'ext_saldo_awal.harsat'
            )
            ->get();

            $datapengeluaran = SaldoAwalModel::join('riwayat_barang_medis as pengeluaran', 'ext_saldo_awal.kode_brng', '=', 'pengeluaran.kode_brng')
            //pengeluaran
            ->join('databarang', 'ext_saldo_awal.kode_brng', '=', 'databarang.kode_brng')
            ->join('jenis', 'databarang.kdjns', '=', 'jenis.kdjns')
            ->where('pengeluaran.tanggal', '>=', $request->tanggal_mulai)
            ->where('pengeluaran.tanggal', '<=', $request->tanggal_selesai)
            ->where('pengeluaran.status', 'Simpan')

            ->select(
                'ext_saldo_awal.kode_brng',
                'databarang.nama_brng',
                'jenis.nama as jenisbarang',
                DB::raw('SUM(pengeluaran.keluar) as qty_pengeluaran'),
            )

            ->groupBy(
                'ext_saldo_awal.kode_brng',
                'databarang.nama_brng',
                'jenis.nama',
                'ext_saldo_awal.qty',
                'ext_saldo_awal.harsat'
            )
            ->get();

            $merged = collect($datawal)->merge($datapenerimaan)->merge($dataretur)->merge($datapengeluaran)->groupBy('kode_brng')->map(function ($items) {
                return $items->reduce(function ($result, $item) {
                    if ($item instanceof SaldoAwalModel) {
                        $item = $item->toArray();
                    }
                    return array_merge($result, $item);
                }, []);
            })->values()->toArray();


            $response = [
                'success' => 'true',
                // 'datawal' =>  $datapenerimaan ,
                'merged'=> $merged,
                // 'data' => PenerimaanObatResource::collection($merged),
                

            ];
            return response()->json($response, Response::HTTP_OK);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        
        
    }
}
