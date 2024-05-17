<?php

namespace App\Http\Controllers;

use App\Http\Resources\RanapResource;
use App\Models\DetailPeriksaLab;
use App\Models\KamarInap;
use App\Models\Laboratorium;
use App\Models\Obat;
use App\Models\Periksa;
use App\Models\Radiologi;
use App\Models\RawatInapDrModel;
use App\Models\RawatInapDrprModel;
use App\Models\RawatInapPrModel;
use App\Models\RawatJlDrModel;
use App\Models\RawatJlDrprModel;
use App\Models\RawatJlPrModel;
use App\Models\RegPeriksaModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class NewPiutangRanap extends Controller
{
    // 
    public function dataRanap(string $jenislayanan, string $tanggal)
    {
        // revisi
        $idUmum = ['A01', 'A09', 'A46', 'A49'];
        $idBpjs = ['BPJ'];
        $cob = ['A02', 'A03', 'A07', 'A08', 'A10', 'A11', 'A12', 'A13', 'A14', 'A15', 'A16', 'A17', 'A18', 'A19', 'A20', 'A21', 'A22', 'A23', 'A24', 'A25', 'A26', 'A27', 'A28', 'A29', 'A30', 'A31', 'A32', 'A33', 'A34', 'A35', 'A36', 'A37', 'A38', 'A40', 'A42', 'A43', 'A45', 'A48', 'A50', 'A51', 'A52', 'A53', 'A54', 'A55', 'A58', 'A61', 'A62', 'A66', 'COB'];
        $kon = ['A05', 'A06', 'A44', 'A47', 'A56', 'A57', 'A60', 'A63', 'A64', 'A65'];
        $ketenagakerjaan= ['A04'];

        $dataJamKamar = Carbon::create($tanggal);

        $norawat = KamarInap::where('stts_pulang', '-')->whereMonth('tgl_masuk', $dataJamKamar)->where('tgl_masuk', '<=', $dataJamKamar)->distinct('no_rawat')->pluck('no_rawat');
        if ($jenislayanan === "umum") {
            $listranap = Periksa::whereIn('no_rawat',  $norawat)->whereIn('kd_pj', $idUmum)->orderBy('kd_pj', 'asc')->get();
        } elseif ($jenislayanan === "bpjs") {
            $listranap = Periksa::whereIn('no_rawat',  $norawat)->whereIn('kd_pj', $idBpjs)->orderBy('kd_pj', 'asc')->get();
        } elseif ($jenislayanan === "cob") {
            $listranap = Periksa::whereIn('no_rawat',  $norawat)->whereIn('kd_pj', $cob)->orderBy('kd_pj', 'asc')->get();
        } elseif ($jenislayanan === "kon") {
            $listranap = Periksa::whereIn('no_rawat',  $norawat)->whereIn('kd_pj', $kon)->orderBy('kd_pj', 'asc')->get();
        } elseif ($jenislayanan === "ketenagakerjaan") {
            $listranap = Periksa::whereIn('no_rawat',  $norawat)->whereIn('kd_pj', $ketenagakerjaan)->orderBy('kd_pj', 'asc')->get();
        } else {
            $listranap = Periksa::whereIn('no_rawat',  $norawat)->orderBy('kd_pj', 'asc')->get();
        }

        $response = [
            'success' => true,
            'message' => 'data list nomer rawat',
            '$norawat' => date($tanggal),
            'data' => RanapResource::collection($listranap),
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function regPeriksa()
    {
        $norawat = KamarInap::where('stts_pulang', '-')->distinct('no_rawat')->pluck('no_rawat');
        $listranap = RegPeriksaModel::whereIn('no_rawat',  $norawat)->get();
        $response = [
            'success' => true,
            'message' => 'data list nomer rawat',
            'data' => $listranap,
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function tindakan()
    {
        $norawat = KamarInap::where('stts_pulang', '-')->distinct('no_rawat')->pluck('no_rawat');
        $layanandrpr = RawatJlDrprModel::whereIn('no_rawat',  $norawat)->get();
        $layanandr = RawatJlDrModel::whereIn('no_rawat',  $norawat)->get();
        $layananpr = RawatJlPrModel::whereIn('no_rawat',  $norawat)->get();
        $umum = RawatInapPrModel::whereIn('no_rawat',  $norawat)->get();
        $rawatInapDr = RawatInapDrModel::whereIn('no_rawat',  $norawat)->get();
        $rawatInapDrPr = RawatInapDrprModel::whereIn('no_rawat',  $norawat)->get();

        $response = [
            'success' => true,
            'message' => 'data list nomer rawat',
            'layanandrpr' => $layanandrpr,
            'layanandr' => $layanandr,
            'layananpr' => $layananpr,
            'umum' => $umum,
            'rawatInapDr' => $rawatInapDr,
            'rawatInapDrPr' => $rawatInapDrPr,
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function obat()
    {
        $norawat = KamarInap::where('stts_pulang', '-')->distinct('no_rawat')->pluck('no_rawat');
        $obat = Obat::whereIn('no_rawat',  $norawat)->get();

        $response = [
            'success' => true,
            'message' => 'data list nomer rawat',
            'obat' => $obat
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    // 
    public function radiologi()
    {
        $norawat = KamarInap::where('stts_pulang', '-')->distinct('no_rawat')->pluck('no_rawat');
        $radiologi = Radiologi::whereIn('no_rawat',  $norawat)->get();

        $response = [
            'success' => true,
            'message' => 'data list nomer rawat',
            'radiologi' => $radiologi
        ];
        return response()->json($response, Response::HTTP_OK);
    }
    //
    public function laboratorium()
    {
        $norawat = KamarInap::where('stts_pulang', '-')->distinct('no_rawat')->pluck('no_rawat');
        $biaya = Laboratorium::whereIn('no_rawat',  $norawat)->get();
        $biaya_item = DetailPeriksaLab::whereIn('no_rawat',  $norawat)->get();
        $response = [
            'success' => true,
            'message' => 'data list nomer rawat',
            'laborat1' => $biaya,
            'laborat2' => $biaya_item
        ];
        return response()->json($response, Response::HTTP_OK);
    }
    public function kamarinap()
    {
        //
        $kamars = KamarInap::where('stts_pulang', '-')->get();
        $dateNow = Carbon::now();

        $totals = 0;
        $array = array();
        foreach ($kamars as $kamar) {
            $dataJamKamar = Carbon::create($kamar->jam_masuk);
            $dataTanggalKamar = Carbon::create($kamar->tgl_masuk);
            $gabung = $dataTanggalKamar->setDate($dataTanggalKamar->year, $dataTanggalKamar->month, $dataTanggalKamar->day)->setTime($dataJamKamar->hour, $dataJamKamar->minute, $dataJamKamar->second);
            $gabungs = $dateNow->diff($gabung);

            if ($dateNow >  $gabung &&  $gabungs->h >= 6) {
                // $totals = $totals+ ( ($dateNow->diff( $gabung)->days+1) * $kamar->trf_kamar);

                $norawat = $kamar->no_rawat;
                $biaya = ($dateNow->diff($gabung)->days + 1) * $kamar->trf_kamar;
            } elseif ($dateNow >  $gabung &&  $gabungs->h < 6) {
                // $totals = $totals+  ($dateNow->diff( $gabung)->days * $kamar->trf_kamar);

                $norawat = $kamar->no_rawat;
                $biaya = ($dateNow->diff($gabung)->days) * $kamar->trf_kamar;
            }
            $array[] = [
                "norawat" => $norawat,
                "biaya" =>  $biaya,
            ];
        }
        // $dokter = KamarInap::where('stts_pulang', '-')->sum('ttl_biaya');
        $response = [
            'success' => true,
            'biaya' => $array,
            // 'total kanza' => $dokter,
        ];
        return response()->json($response, Response::HTTP_OK);
    }
    public function operasi()
    {
        $norawat = KamarInap::where('stts_pulang', '-')->distinct('no_rawat')->pluck('no_rawat');

        $listranap = DB::table('reg_periksa as r')->whereIn('r.no_rawat', $norawat)
            ->join('operasi as operasis', 'r.no_rawat', '=', 'operasis.no_rawat')
            ->select('r.no_rawat', DB::raw('SUM(operasis.biayaoperator1
                                            +operasis.biayaoperator2
                                            +operasis.biayaoperator3
                                            +operasis.biayaasisten_operator1
                                            +operasis.biayaasisten_operator2
                                            +operasis.biayaasisten_operator3
                                            +operasis.biayainstrumen
                                            +operasis.biayadokter_anak
                                            +operasis.biayaperawaat_resusitas
                                            +operasis.biayadokter_anestesi
                                            +operasis.biayaasisten_anestesi
                                            +operasis.biayaasisten_anestesi2
                                            +operasis.biayabidan
                                            +operasis.biayabidan2
                                            +operasis.biayabidan3
                                            +operasis.biayaperawat_luar
                                            +operasis.biayaalat
                                            +operasis.biayasewaok
                                            +operasis.akomodasi
                                            +operasis.bagian_rs
                                            +operasis.biaya_omloop
                                            +operasis.biaya_omloop2
                                            +operasis.biaya_omloop3
                                            +operasis.biaya_omloop4
                                            +operasis.biaya_omloop5
                                            +operasis.biayasarpras
                                            +operasis.biaya_dokter_pjanak
                                            +operasis.biaya_dokter_umum
                                            ) as total_operasi'))
            ->groupBy('r.no_rawat')
            ->get();

        $response = [
            'success' => true,
            'message' => 'data totals',
            'data' => $listranap,
        ];
        return response()->json($response, Response::HTTP_OK);
    }
    public function allTindakan()
    {
        $norawat = KamarInap::where('stts_pulang', '-')->distinct('no_rawat')->pluck('no_rawat');
        //registrasi
        $listranap = RegPeriksaModel::whereIn('no_rawat',  $norawat)->get();
        //tindakan
        $layanandrpr = RawatJlDrprModel::whereIn('no_rawat',  $norawat)->get();
        $layanandr = RawatJlDrModel::whereIn('no_rawat',  $norawat)->get();
        $layananpr = RawatJlPrModel::whereIn('no_rawat',  $norawat)->get();
        $umum = RawatInapPrModel::whereIn('no_rawat',  $norawat)->get();
        $rawatInapDr = RawatInapDrModel::whereIn('no_rawat',  $norawat)->get();
        $rawatInapDrPr = RawatInapDrprModel::whereIn('no_rawat',  $norawat)->get();
        // obat
        $obat = Obat::whereIn('no_rawat',  $norawat)->get();
        //laborat
        $laborat1 = Laboratorium::whereIn('no_rawat',  $norawat)->get();
        $laborat2 = DetailPeriksaLab::whereIn('no_rawat',  $norawat)->get();
        //radiologi
        $radiologi = Radiologi::whereIn('no_rawat',  $norawat)->get();
        //kamar
        $kamars = KamarInap::where('stts_pulang', '-')->get();
        $dateNow = Carbon::now();

        $totals = 0;
        $array = array();
        foreach ($kamars as $kamar) {
            $dataJamKamar = Carbon::create($kamar->jam_masuk);
            $dataTanggalKamar = Carbon::create($kamar->tgl_masuk);
            $gabung = $dataTanggalKamar->setDate($dataTanggalKamar->year, $dataTanggalKamar->month, $dataTanggalKamar->day)->setTime($dataJamKamar->hour, $dataJamKamar->minute, $dataJamKamar->second);
            $gabungs = $dateNow->diff($gabung);

            if ($dateNow >  $gabung &&  $gabungs->h >= 6) {
                // $totals = $totals+ ( ($dateNow->diff( $gabung)->days+1) * $kamar->trf_kamar);

                $norawat = $kamar->no_rawat;
                $biaya = ($dateNow->diff($gabung)->days + 1) * $kamar->trf_kamar;
            } elseif ($dateNow >  $gabung &&  $gabungs->h < 6) {
                // $totals = $totals+  ($dateNow->diff( $gabung)->days * $kamar->trf_kamar);

                $norawat = $kamar->no_rawat;
                $biaya = ($dateNow->diff($gabung)->days) * $kamar->trf_kamar;
            }
            $array[] = [
                "norawat" => $norawat,
                "biaya" =>  $biaya,
            ];
        }


        $response = [
            'success' => true,
            'message' => 'data list nomer rawat',
            // registrasi
            'registrasi' => $listranap,
            // tindakan
            'layanandrpr' => $layanandrpr,
            'layanandr' => $layanandr,
            'layananpr' => $layananpr,
            'umum' => $umum,
            'rawatInapDr' => $rawatInapDr,
            'rawatInapDrPr' => $rawatInapDrPr,
            // obat
            'obat'=>$obat,
            //laborat
            'laborat1' => $laborat1,
            'laborat2' => $laborat2,
            //radiologi
            'radiologi' => $radiologi,
            //kamar
            'biaya' => $array,

            
        ];
        return response()->json($response, Response::HTTP_OK);
    }
}
