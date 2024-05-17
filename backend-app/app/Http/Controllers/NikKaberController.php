<?php

namespace App\Http\Controllers;

use App\Http\Resources\KaberResource;
use App\Models\KamarInap;
use App\Models\Pasien;
use App\Models\Periksa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NikKaberController extends Controller
{
    //
    public function index(string $tanggal)
    {
        //
        $dataJamKamar = Carbon::create($tanggal);
        // $dataRawat=KamarInap::where('tgl_masuk', '>=', $dataJamKamar)->where('kd_kamar', 'LIKE', '%SHINTA%')->orWhere('kd_kamar', 'LIKE', '%PERINA%')->paginate(10)->pluck('no_rawat');
        // $norm = Periksa::whereIn('no_rawat',  $dataRawat)->get();
        $norawat = KamarInap::whereMonth('tgl_masuk',$dataJamKamar->setTimezone('Asia/Jakarta'))->where('kd_kamar', 'LIKE', '%SHINTA%')->distinct('no_rawat')->pluck('no_rawat');
        $norm = Periksa::whereIn('no_rawat', $norawat)->get();
        // $pasien = Pasien::whereIn('no_rkm_medis', $norm)->get();

        $response=[
            'success'=>true,
            // 'message'=> $dataJamKamar,
            'data'=>KaberResource::collection($norm)
            // 'data'=> $norm
        ];
        return response()->json($response, Response::HTTP_OK);

    }
    public function index2(string $tanggal)
    {
        //
        $dataJamKamar = Carbon::create($tanggal);
        // $dataRawat=KamarInap::where('tgl_masuk', '>=', $dataJamKamar)->where('kd_kamar', 'LIKE', '%SHINTA%')->orWhere('kd_kamar', 'LIKE', '%PERINA%')->paginate(10)->pluck('no_rawat');
        // $norm = Periksa::whereIn('no_rawat',  $dataRawat)->get();
        $norawat = KamarInap::whereMonth('tgl_masuk',$dataJamKamar->setTimezone('Asia/Jakarta'))->where('kd_kamar', 'LIKE', '%PERINA%')->distinct('no_rawat')->pluck('no_rawat');
        $norm = Periksa::whereIn('no_rawat', $norawat)->get();
        // $pasien = Pasien::whereIn('no_rkm_medis', $norm)->get();

        $response=[
            'success'=>true,
            // 'message'=> $dataJamKamar,
            'data'=>KaberResource::collection($norm)
            // 'data'=> $norm
        ];
        return response()->json($response, Response::HTTP_OK);

    }
}
