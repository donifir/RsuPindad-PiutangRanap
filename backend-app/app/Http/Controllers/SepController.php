<?php

namespace App\Http\Controllers;

use App\Http\Resources\SepResource;
use App\Models\Periksa;
use Symfony\Component\HttpFoundation\Response;

class SepController extends Controller
{
    //
    public function index(string $tanggal)
    {
        $data = Periksa::where('tgl_registrasi',$tanggal)->where('kd_pj','BPJ')->get();
        $response = [
            'success' => true,
            'message' => 'data list nomer rawat ianp tanggal '.$tanggal,
            'data' =>  SepResource::collection($data)
        ];
        return response()->json($response, Response::HTTP_OK);
    }
    //
    public function indexsep(string $tanggal)
    {
        $data = Periksa::where('tgl_registrasi',$tanggal)->where('status_lanjut', 'Ralan')->where('kd_pj','BPJ')->where('kd_poli','<>','IGDK')->get();
        $response = [
            'success' => true,
            'message' => 'data list nomer rawat ianp tanggal '.$tanggal,
            'data' =>  SepResource::collection($data)
        ];
        return response()->json($response, Response::HTTP_OK);
    }
}
