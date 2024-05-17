<?php

namespace App\Http\Controllers;

use App\Http\Resources\PengadaanAdjust;
use App\Models\Databarang;
use App\Models\SaldoAwalModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PengadaanAdjustController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = SaldoAwalModel::select('nama_bulan')->distinct()->get();
        $response = [
            'success' => true,
            'message' => 'data list nomer rawat',
            'data' => PengadaanAdjust::collection($data)
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function showdetail(string $id)
    {
        //
        $data = SaldoAwalModel::find($id);
        $response = [
            'success' => true,
            'message' => 'data list nomer rawat',
            'data' => $data
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $namabulan)
    {
        //
        $data = SaldoAwalModel::where('nama_bulan', $namabulan)->orderBy('id', 'desc')->get();
        $response = [
            'success' => true,
            'message' => 'data list nomer rawat',
            'data' => $data
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'kode_brng' => 'required|unique:ext_saldo_awal,kode_brng|exists:databarang,kode_brng',
            // 'nama_item' => 'required|unique:ext_saldo_awal,nama_item|exists:databarang,nama_brng',
            'qty' => 'required|numeric',
            'harsat' => 'required|numeric',
            'nilai' => 'required|numeric',
            'nama_bulan' => 'required|exists:ext_saldo_awal,nama_bulan',
        ]);
        $barang = Databarang::where('kode_brng', $request->kode_brng)->first();
        if ($validator->fails()) {
            $response = [
                'success' => 'false',
                'message' =>  $validator->errors(),
                'data' => '',
            ];
            return response()->json($response, Response::HTTP_UNPROCESSABLE_ENTITY);
        } else if (!$barang) {
            $response = [
                'success' => 'false',
                'message' => ['kode_brng' => 'kode barang tidak ditemukan'],
                'data' => '',
            ];
            return response()->json($response, Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            $databarang = Databarang::where('kode_brng', $request->kode_brng)->first();
            $berita = SaldoAwalModel::create([
                'kode_brng' => $request->kode_brng,
                'nama_item' => $databarang->nama_brng,
                'qty' => $request->qty,
                'harsat' => $request->harsat,
                'nilai' => $request->nilai,
                'nama_bulan' => $request->nama_bulan,
            ]);
            $response = [
                'success' => 'true',
                'message' => 'data created',
                'data' => $berita,
            ];
            return response()->json($response, Response::HTTP_OK);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validator = Validator::make($request->all(), [
            'qty' => 'required|numeric',
            'harsat' => 'required|numeric',
            'nilai' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            $response = [
                'success' => 'false',
                'message' => $validator->errors(),
                'data' => '',
            ];
            return response()->json($response, Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            $berita = SaldoAwalModel::find($id);
            $berita->update([
                'qty' => $request->qty,
                'harsat' => $request->harsat,
                'nilai' => $request->nilai,
            ]);
            $response = [
                'success' => 'true',
                'message' => 'data updated',
                'data' => $berita,
            ];
            return response()->json($response, Response::HTTP_OK);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        SaldoAwalModel::find($id)->delete();
        $response = [
            'success' => 'true',
            'message' => 'data deleted',
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyed(string $id)
    {
        SaldoAwalModel::where('nama_bulan', $id)->delete();
        $response = [
            'success' => 'true',
            'message' => 'data deleted',
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function stored(Request $request)
    {

        $data = $request->input('newArray'); // Mendapatkan data dari permintaan

        // Lakukan iterasi data dan simpan ke dalam database
        foreach ($data as $item) {
            SaldoAwalModel::create([
                'kode_brng' => $item['kode_brng'],
                'nama_item' => $item['nama_brng'],
                'nama_bulan' => $item['nama_bulan'],
                'qty' => $item['qty_saldo_awal'] ?? 0,
                'harsat' => $item['harsat_saldo_awal'] ?? 0,
                'nilai' => $item['nilai_saldo_awal'] ?? 0,
            ]);
        }

        // return response()->json(['message' => $data], 200);
        return response()->json(['message' => 'Data saved successfully'], 200);
    }
}
