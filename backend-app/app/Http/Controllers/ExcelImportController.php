<?php

namespace App\Http\Controllers;

use App\Imports\SaldoAwalImport;
use App\Models\SaldoAwalModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class ExcelImportController extends Controller
{
    //
    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls',
            'nama_bulan' => 'required',
        ]);
        if ($validator->fails()) {
            $response = [
                'success' => 'false',
                'message' => $validator->errors(),
                'data' => '',
            ];
            return response()->json($response, Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            // SaldoAwalModel::truncate();
            Excel::import(new SaldoAwalImport, request()->file('file'));

            $data = SaldoAwalModel::where('nama_bulan', null);
            $data->update([
                'nama_bulan' => $request->nama_bulan,
            ]);
            $response = [
                'success' => true,
                'message' => 'data uploaded',
                // 'data' => $listranap,
            ];
            return response()->json($response, Response::HTTP_OK);
        }
    }
}
