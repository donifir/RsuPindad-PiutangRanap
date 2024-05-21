<?php

namespace App\Http\Controllers;

use App\Models\mlite_antrian_loket;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TaksIdController extends Controller

{

    /**
     * Show the form for creating a new resource.
     */
    public function taksidall(string $tanggal)
    {
        //
        $datatotalregist = DB::table('reg_periksa as r')
            ->where('r.tgl_registrasi', $tanggal)
            ->where('r.status_lanjut', 'Ralan')
            // ->get();
            ->count();
        $datatotalregistsp = DB::table('reg_periksa as r')
            ->where('r.tgl_registrasi', $tanggal)
            ->where('r.status_lanjut', 'Ralan')
            ->where('r.kd_poli', '<>', 'IGDK')
            ->where('r.kd_poli', '<>', 'U0017')
            ->where('r.kd_poli', '<>', 'U0019')
            ->where('r.kd_poli', '<>', 'U0077')
            ->where('r.kd_poli', '<>', 'U24 0')
            ->where('r.kd_poli', '<>', 'U0009')
            ->where('r.kd_poli', '<>', 'U0048')
            // ->get();
            ->count();
        $taks1 = DB::table('mlite_antrian_loket')->where('no_rkm_medis', '<>', null)->where('postdate', $tanggal)->where('start_time', '<>', '00:00:00')->count();
        $taks2 = DB::table('mlite_antrian_loket')->where('no_rkm_medis', '<>', null)->where('postdate', $tanggal)->where('end_time', '<>', '00:00:00')->count();
        $taks3 = DB::table('reg_periksa as r')
            ->where('r.tgl_registrasi', $tanggal)
            ->where('r.status_lanjut', 'Ralan')
            ->join('mutasi_berkas as mutasi', 'r.no_rawat', '=', 'mutasi.no_rawat')
            ->where('mutasi.dikirim', '<>', '0000-00-00 00:00:00',)
            // ->get();
            ->count();

        $taks4 = DB::table('reg_periksa as r')
            ->where('r.tgl_registrasi', $tanggal)
            ->where('r.status_lanjut', 'Ralan')
            ->join('mutasi_berkas as mutasi', 'r.no_rawat', '=', 'mutasi.no_rawat')
            ->where('mutasi.diterima', '<>', '0000-00-00 00:00:00',)
            // ->get();
            ->count();

        $taks5 = DB::table('reg_periksa as r')
            ->where('r.tgl_registrasi', $tanggal)
            ->where('r.status_lanjut', 'Ralan')
            ->join('pemeriksaan_ralan as pemeriksaan', 'r.no_rawat', '=', 'pemeriksaan.no_rawat')
            // ->where('mutasi.diterima','<>', '0000-00-00 00:00:00')
            // ->get();
            ->count();

        $taks6 = DB::table('reg_periksa as r')
            ->where('r.tgl_registrasi', $tanggal)
            ->where('r.status_lanjut', 'Ralan')
            ->join('resep_obat as obat', 'r.no_rawat', '=', 'obat.no_rawat')
            ->where('obat.jam_peresepan', '<>', '00:00:00',)
            // ->get();
            ->count();

        $taks7 = DB::table('reg_periksa as r')
            ->where('r.tgl_registrasi', $tanggal)
            ->where('r.status_lanjut', 'Ralan')
            ->join('resep_obat as obat', 'r.no_rawat', '=', 'obat.no_rawat')
            ->where('obat.jam', '<>', '00:00:00')
            // ->get();
            ->count();

        $response = [
            'success' => true,
            'message' => 'data taksid',
            'tanggal' => $tanggal,
            'total_regis' => $datatotalregist,
            'total_regis_sp' => $datatotalregistsp,
            'taks1' => $taks1,
            'taks2' => $taks2,
            'taks3' => $taks3,
            'taks4' => $taks4,
            'taks5' => $taks5,
            'taks6' => $taks6,
            'taks7' => $taks7,
        ];
        return response()->json($response, Response::HTTP_OK);
    }
}
