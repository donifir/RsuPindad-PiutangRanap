<?php

namespace App\Http\Controllers;

use App\Http\Resources\JppkResource;
use App\Models\KamarInap;
use App\Models\Periksa;
use App\Models\RegPeriksaModel;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JppkAllController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data =["A10","A11","A12","A13","A14","A15","A16","A17","A18","A19","A20","A21","A22","A23","A24","A25","A26","A28","A29","A30","A34","A35","A36","A37","A40","A42","A43","A45","A48","COB"];
        // $norawat = Periksa::where('stts_pulang', '-')->distinct('no_rawat')->pluck('no_rawat');
        $listranap = Periksa::whereIn('kd_pj',  $data)->where('tgl_registrasi','>','2022-01-10')->get();
        $response = [
            'success' => true,
            'message' => 'data list nomer rawat',
            'data' => JppkResource::collection($listranap),
        ];
        return response()->json($response, Response::HTTP_OK);
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
