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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class NewPiutangRanapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function dataRanap(string $jenislayanan, string $tanggal)
    {
        // revisi
        $idUmum = ['A01', 'A09', 'A46', 'A49'];
        $idBpjs = ['BPJ'];
        $cob = ['A02', 'A03', 'A07', 'A08', 'A10', 'A11', 'A12', 'A13', 'A14', 'A15', 'A16', 'A17', 'A18', 'A19', 'A20', 'A21', 'A22', 'A23', 'A24', 'A25', 'A26', 'A27', 'A28', 'A29', 'A30', 'A31', 'A32', 'A33', 'A34', 'A35', 'A36', 'A37', 'A38', 'A40', 'A42', 'A43', 'A45', 'A48', 'A50', 'A51', 'A52', 'A53', 'A54', 'A55', 'A58', 'A61', 'A62', 'A66', 'COB'];
        $kon = ['A05', 'A06', 'A44', 'A47', 'A56', 'A57', 'A60', 'A63', 'A64', 'A65'];
        $ketenagakerjaan = ['A04'];

        $dataJamKamar = Carbon::create($tanggal);

        $norawat = KamarInap::where('stts_pulang', '-')->where('tgl_masuk', '<=', $dataJamKamar)->distinct('no_rawat')->pluck('no_rawat');
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

    public function allTindakan(string $jenislayanan, string $tanggal)
    {
        // revisi
        $idUmum = ['A01', 'A09', 'A46', 'A49'];
        $idBpjs = ['BPJ'];
        $cob = ['A02', 'A03', 'A07', 'A08', 'A10', 'A11', 'A12', 'A13', 'A14', 'A15', 'A16', 'A17', 'A18', 'A19', 'A20', 'A21', 'A22', 'A23', 'A24', 'A25', 'A26', 'A27', 'A28', 'A29', 'A30', 'A31', 'A32', 'A33', 'A34', 'A35', 'A36', 'A37', 'A38', 'A40', 'A42', 'A43', 'A45', 'A48', 'A50', 'A51', 'A52', 'A53', 'A54', 'A55', 'A58', 'A61', 'A62', 'A66', 'COB'];
        $kon = ['A05', 'A06', 'A44', 'A47', 'A56', 'A57', 'A60', 'A63', 'A64', 'A65'];
        $ketenagakerjaan = ['A04'];

        $dataJamKamar = Carbon::create($tanggal);

        $norawat = KamarInap::where('stts_pulang', '-')->where('tgl_masuk', '<=', $dataJamKamar)->distinct('no_rawat')->pluck('no_rawat');
        if ($jenislayanan === "umum") {
            $norawats = Periksa::whereIn('no_rawat',  $norawat)->whereIn('kd_pj', $idUmum)->orderBy('kd_pj', 'asc')->distinct('no_rawat')->pluck('no_rawat');
        } elseif ($jenislayanan === "bpjs") {
            $norawats = Periksa::whereIn('no_rawat',  $norawat)->whereIn('kd_pj', $idBpjs)->orderBy('kd_pj', 'asc')->distinct('no_rawat')->pluck('no_rawat');
        } elseif ($jenislayanan === "cob") {
            $norawats = Periksa::whereIn('no_rawat',  $norawat)->whereIn('kd_pj', $cob)->orderBy('kd_pj', 'asc')->distinct('no_rawat')->pluck('no_rawat');
        } elseif ($jenislayanan === "kon") {
            $norawats = Periksa::whereIn('no_rawat',  $norawat)->whereIn('kd_pj', $kon)->orderBy('kd_pj', 'asc')->distinct('no_rawat')->pluck('no_rawat');
        } elseif ($jenislayanan === "ketenagakerjaan") {
            $norawats = Periksa::whereIn('no_rawat',  $norawat)->whereIn('kd_pj', $ketenagakerjaan)->orderBy('kd_pj', 'asc')->distinct('no_rawat')->pluck('no_rawat');
        } else {
            $norawats = Periksa::whereIn('no_rawat',  $norawat)->orderBy('kd_pj', 'asc')->distinct('no_rawat')->pluck('no_rawat');
        }

        $listranap = RegPeriksaModel::whereIn('no_rawat',  $norawats)->get();
        //tindakan
        $layanandrpr = RawatJlDrprModel::whereIn('no_rawat', $norawats)->get();
        $layanandr = RawatJlDrModel::whereIn('no_rawat', $norawats)->get();
        $layananpr = RawatJlPrModel::whereIn('no_rawat', $norawats)->get();
        $umum = RawatInapPrModel::whereIn('no_rawat', $norawats)->get();
        $rawatInapDr = RawatInapDrModel::whereIn('no_rawat', $norawats)->get();
        $rawatInapDrPr = RawatInapDrprModel::whereIn('no_rawat', $norawats)->get();
        // obat
        $obat = Obat::whereIn('no_rawat', $norawats)->get();
        //laborat
        $laborat1 = Laboratorium::whereIn('no_rawat', $norawats)->get();
        $laborat2 = DetailPeriksaLab::whereIn('no_rawat', $norawats)->get();
        //radiologi
        $radiologi = Radiologi::whereIn('no_rawat', $norawats)->get();
        //kamar
        $kamars = KamarInap::where('stts_pulang', '-')->whereIn('no_rawat', $norawats)->get();
        $dateNow = Carbon::now()->timezone('Asia/Jakarta');
        // operasi
        $operasi = DB::table('reg_periksa as r')->whereIn('r.no_rawat', $norawats)
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
        $array = array();
        foreach ($kamars as $kamar) {
            $dataJamKamar = Carbon::create($kamar->jam_masuk);
            $dataTanggalKamar = Carbon::create($kamar->tgl_masuk);
            $gabung = $dataTanggalKamar->setDate($dataTanggalKamar->year, $dataTanggalKamar->month, $dataTanggalKamar->day)->setTime($dataJamKamar->hour, $dataJamKamar->minute, $dataJamKamar->second);
            $gabungs = $dateNow->diff($gabung);

            if ($dateNow >  $gabung &&  $gabungs->h >= 6) {
                $norawat = $kamar->no_rawat;
                $biaya = ($dateNow->diff($gabung)->days + 1) * $kamar->trf_kamar;
            } elseif ($dateNow >  $gabung &&  $gabungs->h < 6) {
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
            'registrasi' => $listranap,
            'layanandrpr' => $layanandrpr,
            'layanandr' => $layanandr,
            'layananpr' => $layananpr,
            'umum' => $umum,
            'rawatInapDr' => $rawatInapDr,
            'rawatInapDrPr' => $rawatInapDrPr,
            'obat' => $obat,
            'laborat1' => $laborat1,
            'laborat2' => $laborat2,
            'radiologi' => $radiologi,
            'biaya' => $array,
            'operasi' => $operasi


        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function totalAllTindakan(string $jenislayanan, string $tanggal)
    {
        // revisi
        $idUmum = ['A01', 'A09', 'A46', 'A49'];
        $idBpjs = ['BPJ'];
        $cob = ['A02', 'A03', 'A07', 'A08', 'A10', 'A11', 'A12', 'A13', 'A14', 'A15', 'A16', 'A17', 'A18', 'A19', 'A20', 'A21', 'A22', 'A23', 'A24', 'A25', 'A26', 'A27', 'A28', 'A29', 'A30', 'A31', 'A32', 'A33', 'A34', 'A35', 'A36', 'A37', 'A38', 'A40', 'A42', 'A43', 'A45', 'A48', 'A50', 'A51', 'A52', 'A53', 'A54', 'A55', 'A58', 'A61', 'A62', 'A66', 'COB'];
        $kon = ['A05', 'A06', 'A44', 'A47', 'A56', 'A57', 'A60', 'A63', 'A64', 'A65'];
        $ketenagakerjaan = ['A04'];

        $dataJamKamar = Carbon::create($tanggal);

        $norawat = KamarInap::where('stts_pulang', '-')->where('tgl_masuk', '<=', $dataJamKamar)->distinct('no_rawat')->pluck('no_rawat');
        if ($jenislayanan === "umum") {
            $norawats = Periksa::whereIn('no_rawat',  $norawat)->whereIn('kd_pj', $idUmum)->orderBy('kd_pj', 'asc')->distinct('no_rawat')->pluck('no_rawat');
        } elseif ($jenislayanan === "bpjs") {
            $norawats = Periksa::whereIn('no_rawat',  $norawat)->whereIn('kd_pj', $idBpjs)->orderBy('kd_pj', 'asc')->distinct('no_rawat')->pluck('no_rawat');
        } elseif ($jenislayanan === "cob") {
            $norawats = Periksa::whereIn('no_rawat',  $norawat)->whereIn('kd_pj', $cob)->orderBy('kd_pj', 'asc')->distinct('no_rawat')->pluck('no_rawat');
        } elseif ($jenislayanan === "kon") {
            $norawats = Periksa::whereIn('no_rawat',  $norawat)->whereIn('kd_pj', $kon)->orderBy('kd_pj', 'asc')->distinct('no_rawat')->pluck('no_rawat');
        } elseif ($jenislayanan === "ketenagakerjaan") {
            $norawats = Periksa::whereIn('no_rawat',  $norawat)->whereIn('kd_pj', $ketenagakerjaan)->orderBy('kd_pj', 'asc')->distinct('no_rawat')->pluck('no_rawat');
        } else {
            $norawats = Periksa::whereIn('no_rawat',  $norawat)->orderBy('kd_pj', 'asc')->distinct('no_rawat')->pluck('no_rawat');
        }

        $listranap = RegPeriksaModel::whereIn('no_rawat',  $norawats)->get()->sum('biaya_reg');
        //tindakan
        $layanandrpr = RawatJlDrprModel::whereIn('no_rawat', $norawats)->get()->sum('biaya_rawat');
        $layanandr = RawatJlDrModel::whereIn('no_rawat', $norawats)->get()->sum('biaya_rawat');
        $layananpr = RawatJlPrModel::whereIn('no_rawat', $norawats)->get()->sum('biaya_rawat');
        $rawatInapPr = RawatInapPrModel::whereIn('no_rawat', $norawats)->get()->sum('biaya_rawat');
        $rawatInapDr = RawatInapDrModel::whereIn('no_rawat', $norawats)->get()->sum('biaya_rawat');
        $rawatInapDrPr = RawatInapDrprModel::whereIn('no_rawat', $norawats)->get()->sum('biaya_rawat');
        // obat
        $obat = Obat::whereIn('no_rawat', $norawats)->get()->sum('total');
        //laborat
        $laborat1 = Laboratorium::whereIn('no_rawat', $norawats)->get()->sum('biaya');
        $laborat2 = DetailPeriksaLab::whereIn('no_rawat', $norawats)->get()->sum('biaya_item');
        //radiologi
        $radiologi = Radiologi::whereIn('no_rawat', $norawats)->get()->sum('biaya');
        //kamar
        $kamars = KamarInap::where('stts_pulang', '-')->whereIn('no_rawat', $norawats)->get();
        $dateNow = Carbon::now()->timezone('Asia/Jakarta');
        // operasi
        $operasi = DB::table('reg_periksa as r')->whereIn('r.no_rawat', $norawats)
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
            ->get()->sum('total_operasi');
        $array = array();
        foreach ($kamars as $kamar) {
            $dataJamKamar = Carbon::create($kamar->jam_masuk);
            $dataTanggalKamar = Carbon::create($kamar->tgl_masuk);
            $gabung = $dataTanggalKamar->setDate($dataTanggalKamar->year, $dataTanggalKamar->month, $dataTanggalKamar->day)->setTime($dataJamKamar->hour, $dataJamKamar->minute, $dataJamKamar->second);
            $gabungs = $dateNow->diff($gabung);

            if ($dateNow >  $gabung &&  $gabungs->h >= 6) {
                $norawat = $kamar->no_rawat;
                $biaya = ($dateNow->diff($gabung)->days + 1) * $kamar->trf_kamar;
            } elseif ($dateNow >  $gabung &&  $gabungs->h < 6) {
                $norawat = $kamar->no_rawat;
                $biaya = ($dateNow->diff($gabung)->days) * $kamar->trf_kamar;
            }
            $array[] = [
                // "norawat" => $norawat,
                "biaya" =>  $biaya,
            ];
        }
        $totalBiaya = array_reduce($array, function ($carry, $item) {
            return $carry + $item['biaya'];
        }, 0);

        $totaltindakan=$layanandrpr + $layanandr + $layananpr + $rawatInapPr + $rawatInapDr + $rawatInapDrPr;
        $totallab= $laborat1 + $laborat2;
        $response = [
            'success' => true,
            'message' => 'data list nomer rawat',
            'data' => [
                'registrasi' => $listranap,
                'tindakans' => $totaltindakan,
                // 'layanandrpr' => $layanandrpr,
                // 'layanandr' => $layanandr,
                // 'layananpr' => $layananpr,
                // 'rawatInapPr' => $rawatInapPr,
                // 'rawatInapDr' => $rawatInapDr,
                // 'rawatInapDrPr' => $rawatInapDrPr,
                'obat' => $obat,
                'laboratorium' => $totallab,
                // 'laborat1' => $laborat1,
                // 'laborat2' => $laborat2,
                'radiologi' => $radiologi,
                'kamar' =>  $totalBiaya,
                'operasi' => $operasi,
                'total' => $listranap+ $totaltindakan+$obat+$totallab+$radiologi+$totalBiaya+$operasi
            ]


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
