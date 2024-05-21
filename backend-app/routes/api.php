<?php

use App\Http\Controllers\ExcelImportController;
use App\Http\Controllers\JppkAllController;
use App\Http\Controllers\NewPiutangRanap;
use App\Http\Controllers\NewPiutangRanapController;
use App\Http\Controllers\NikKaberController;
use App\Http\Controllers\NomerTelpRanap;
use App\Http\Controllers\PengadaanAdjustController;
use App\Http\Controllers\PengadaanController;
use App\Http\Controllers\PiutangRanapController;
use App\Http\Controllers\SepController;
use App\Http\Controllers\TaksIdController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('piutangharian', [PiutangRanapController::class, 'pitangHarian']);
Route::get('piutangharianpaginate', [PiutangRanapController::class, 'pitangHarianPaginate']);

Route::get('kamar-inap', [PiutangRanapController::class, 'kamarinap']);
Route::get('get-nomer-ranap', [PiutangRanapController::class, 'nomerranap']);
Route::get('reg-periksa', [PiutangRanapController::class, 'regPeriksa']);
Route::get('radiologi', [PiutangRanapController::class, 'radiologi']);
Route::get('obat', [PiutangRanapController::class, 'obat']);
Route::get('operasi', [PiutangRanapController::class, 'operasi']);
Route::get('lab', [PiutangRanapController::class, 'laboratorium']);
Route::get('lab2', [PiutangRanapController::class, 'laboratorium2']);
Route::get('tindakan', [PiutangRanapController::class, 'tindakan']);
// Route::get('total', [PiutangRanapController::class, 'total']);
Route::get('total/{jenislayanan}/{tgl}', [PiutangRanapController::class, 'total']);


Route::get('telp/{tanggal}', [NomerTelpRanap::class, 'index']);

Route::get('all-tindakan/{jenislayanan}/{tanggal}', [NewPiutangRanapController::class, 'allTindakan']);
Route::get('get-data-ranap/{id}/{tanggal}', [NewPiutangRanapController::class, 'dataRanap']);
Route::get('total-data-ranap/{id}/{tanggal}', [NewPiutangRanapController::class, 'totalAllTindakan']);

// Route::get('get-data-ranap', [NewPiutangRanap::class, 'dataRanap']);
// Route::get('get-data-ranap/{id}/{tanggal}', [NewPiutangRanap::class, 'dataRanap']);
Route::get('get-data-registrasi', [NewPiutangRanap::class, 'regPeriksa']);
Route::get('get-data-tindakan', [NewPiutangRanap::class, 'tindakan']);
Route::get('get-data-obat', [NewPiutangRanap::class, 'obat']);
Route::get('get-data-radiologi', [NewPiutangRanap::class, 'radiologi']);
Route::get('get-data-laborat', [NewPiutangRanap::class, 'laboratorium']);
Route::get('get-data-kamar', [NewPiutangRanap::class, 'kamarinap']);
Route::get('get-data-operasi', [NewPiutangRanap::class, 'operasi']);
Route::get('get-data-alltindakan', [NewPiutangRanap::class, 'allTindakan']);

// nik untuk kaber
Route::get('nik-kaber/{tanggal}', [NikKaberController::class, 'index']);
Route::get('nik-kaber2/{tanggal}', [NikKaberController::class, 'index2']);

Route::get('jppk-all', [JppkAllController::class, 'index']);

// pengadaaan
Route::get('data-barang', [PengadaanController::class, 'index']);
Route::post('data-pemesanan', [PengadaanController::class, 'pemesanan']);
Route::post('pull-data', [PengadaanController::class, 'pulldata']);
Route::post('import-excel', [ExcelImportController::class, 'import']);

Route::get('data-adjust', [PengadaanAdjustController::class, 'index']);
Route::delete('data-adjust/delete/{id}', [PengadaanAdjustController::class, 'destroyed']);


Route::get('data-adjust/{namabulan}', [PengadaanAdjustController::class, 'show']);
Route::get('data-adjust/barang/{id}', [PengadaanAdjustController::class, 'showdetail']);
Route::post('data-adjust/barang/craete', [PengadaanAdjustController::class, 'store']);
Route::post('data-adjust/barang/update/{id}', [PengadaanAdjustController::class, 'update']);
Route::delete('data-adjust/barang/delete/{id}', [PengadaanAdjustController::class, 'destroy']);

Route::post('data-adjust/stored-data', [PengadaanAdjustController::class, 'stored']);


// data sep
Route::get('get-sep/{tanggal}', [SepController::class, 'index']);
Route::get('get-sep-2/{tanggal}', [SepController::class, 'indexsep']);

// taksid
Route::get('taks-id-all/{tanggal}', [TaksIdController::class, 'taksidall']);
