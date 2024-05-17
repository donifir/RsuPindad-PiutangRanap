<?php

namespace App\Http\Controllers;

use App\Http\Resources\TelpResource;
use App\Models\KamarInap;
use App\Models\Pasien;
use App\Models\Periksa;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NomerTelpRanap extends Controller
{
    //
    public function index(string $tanggal)
    {
        $norawat = KamarInap::where('tgl_masuk',$tanggal)->distinct('no_rawat')->pluck('no_rawat');
        $norm = Periksa::whereIn('no_rawat',  $norawat)->pluck('no_rkm_medis');
        $pasien = Pasien::whereIn('no_rkm_medis', $norm)->get();

        $response = [
            'success' => true,
            'message' => 'data list nomer rawat ianp tanggal '.$tanggal,
            'data' => $pasien 
        ];
        return response()->json($response, Response::HTTP_OK);
    }
}
