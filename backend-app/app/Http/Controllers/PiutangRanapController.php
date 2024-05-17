<?php

namespace App\Http\Controllers;

use App\Http\Resources\PiutangHarianResource;
use App\Models\DetailPeriksaLab;
use App\Models\KamarInap;
use App\Models\Laboratorium;
use App\Models\Obat;
use App\Models\Operasi;
use App\Models\Periksa;
use App\Models\PiutangHarian;
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

class PiutangRanapController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function pitangHarianPaginate()
    {
        //
        
        $data = PiutangHarian::orderBy('id', 'asc')->paginate(7);
        $response = [
            'success' => true,
            'data_total' => $data->pluck('harian'),
            'data_label' => $data->pluck('tanggal')
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function pitangHarian()
    {
        //
        $data = PiutangHarian::orderBy('id', 'desc')->get();
        $response = [
            'success' => true,
            'message' => 'data tentang kami',
            'data' => PiutangHarianResource::collection($data),
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function kamarinap()
    {
        //
        $kamars = KamarInap::where('stts_pulang', '-')->get();
        $dateNow = Carbon::now();

        $totals = 0;

        foreach ($kamars as $kamar) {
            $dataJamKamar = Carbon::create($kamar->jam_masuk);
            $dataTanggalKamar = Carbon::create($kamar->tgl_masuk);
            $gabung = $dataTanggalKamar->setDate($dataTanggalKamar->year, $dataTanggalKamar->month, $dataTanggalKamar->day)->setTime($dataJamKamar->hour, $dataJamKamar->minute, $dataJamKamar->second);
            $gabungs = $dateNow->diff($gabung);

            if ($dateNow >  $gabung &&  $gabungs->h >= 6) {
                $totals = $totals + (($dateNow->diff($gabung)->days + 1) * $kamar->trf_kamar);
            } elseif ($dateNow >  $gabung &&  $gabungs->h < 6) {
                $totals = $totals +  ($dateNow->diff($gabung)->days * $kamar->trf_kamar);
            }
        }

        $dokter = KamarInap::where('stts_pulang', '-')->sum('ttl_biaya');
        $response = [
            'success' => true,
            'total koding' => $totals,
            'total kanza' => $dokter,
        ];
        return response()->json($response, Response::HTTP_OK);
    }
    // 
    public function nomerranap()
    {
        $listranap = KamarInap::where('stts_pulang', '-')->distinct('no_rawat')->pluck('no_rawat');
        $response = [
            'success' => true,
            'message' => 'data list nomer rawat',
            'data' => $listranap,
        ];
        return response()->json($response, Response::HTTP_OK);
    }
    // 
    public function regPeriksa()
    {
        $norawat = KamarInap::where('stts_pulang', '-')->distinct('no_rawat')->pluck('no_rawat');
        $listranap = RegPeriksaModel::whereIn('no_rawat',  $norawat)->sum('biaya_reg');
        $response = [
            'success' => true,
            'message' => 'data list nomer rawat',
            'data' => $listranap,
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    // 
    public function obat()
    {
        $norawat = KamarInap::where('stts_pulang', '-')->distinct('no_rawat')->pluck('no_rawat');
        $obat = Obat::whereIn('no_rawat',  $norawat)->sum('total');

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
        $obat = Radiologi::whereIn('no_rawat',  $norawat)->sum('biaya');

        $response = [
            'success' => true,
            'message' => 'data list nomer rawat',
            'obat' => $obat
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    // 
    public function operasi()
    {
        $norawat = KamarInap::where('stts_pulang', '-')->distinct('no_rawat')->pluck('no_rawat');
        $biayaoperator1 = Operasi::whereIn('no_rawat',  $norawat)->sum('biayaoperator1');
        $biayaoperator2 = Operasi::whereIn('no_rawat',  $norawat)->sum('biayaoperator2');
        $biayaoperator3 = Operasi::whereIn('no_rawat',  $norawat)->sum('biayaoperator3');
        $biayaasisten_operator1 = Operasi::whereIn('no_rawat',  $norawat)->sum('biayaasisten_operator1');
        $biayaasisten_operator2 = Operasi::whereIn('no_rawat',  $norawat)->sum('biayaasisten_operator2');
        $biayaasisten_operator3 = Operasi::whereIn('no_rawat',  $norawat)->sum('biayaasisten_operator3');
        $biayainstrumen = Operasi::whereIn('no_rawat',  $norawat)->sum('biayainstrumen');
        $dokter_anak = Operasi::whereIn('no_rawat',  $norawat)->sum('dokter_anak');
        $perawaat_resusitas  = Operasi::whereIn('no_rawat',  $norawat)->sum('perawaat_resusitas');
        $biayadokter_anestesi = Operasi::whereIn('no_rawat',  $norawat)->sum('biayadokter_anestesi');
        $biayaasisten_anestesi = Operasi::whereIn('no_rawat',  $norawat)->sum('biayaasisten_anestesi');
        $biayaasisten_anestesi2 = Operasi::whereIn('no_rawat',  $norawat)->sum('biayaasisten_anestesi2');
        $biayabidan = Operasi::whereIn('no_rawat',  $norawat)->sum('biayabidan');
        $biayabidan2 = Operasi::whereIn('no_rawat',  $norawat)->sum('biayabidan2');
        $biayabidan2 = Operasi::whereIn('no_rawat',  $norawat)->sum('biayabidan2');
        $biayabidan3 = Operasi::whereIn('no_rawat',  $norawat)->sum('biayabidan3');
        $biayaperawat_luar = Operasi::whereIn('no_rawat',  $norawat)->sum('biayaperawat_luar');
        $biayaalat = Operasi::whereIn('no_rawat',  $norawat)->sum('biayaalat');
        $biayasewaok = Operasi::whereIn('no_rawat',  $norawat)->sum('biayasewaok');
        $akomodasi = Operasi::whereIn('no_rawat',  $norawat)->sum('akomodasi');
        $bagian_rs = Operasi::whereIn('no_rawat',  $norawat)->sum('bagian_rs');
        $biaya_omloop = Operasi::whereIn('no_rawat',  $norawat)->sum('biaya_omloop');
        $biaya_omloop2 = Operasi::whereIn('no_rawat',  $norawat)->sum('biaya_omloop2');
        $biaya_omloop3 = Operasi::whereIn('no_rawat',  $norawat)->sum('biaya_omloop3');
        $biaya_omloop4 = Operasi::whereIn('no_rawat',  $norawat)->sum('biaya_omloop4');
        $biaya_omloop5 = Operasi::whereIn('no_rawat',  $norawat)->sum('biaya_omloop3');
        $biayasarpras = Operasi::whereIn('no_rawat',  $norawat)->sum('biayasarpras');
        $biaya_dokter_pjanak = Operasi::whereIn('no_rawat',  $norawat)->sum('biaya_dokter_pjanak');
        $biaya_dokter_umum = Operasi::whereIn('no_rawat',  $norawat)->sum('biaya_dokter_umum');

        $response = [
            'success' => true,
            'message' => 'data list oeprasi',
            'obat' =>
            $biayaoperator1 +
                $biayaoperator2 +
                $biayaoperator3 +
                $biayaasisten_operator1 +
                $biayaasisten_operator2 +
                $biayaasisten_operator3 +
                $biayainstrumen +
                $dokter_anak +
                $perawaat_resusitas +
                $biayadokter_anestesi +
                $biayaasisten_anestesi +
                $biayaasisten_anestesi2 +
                $biayabidan +
                $biayabidan2 +
                $biayabidan3 +
                $biayaalat +
                $biayaperawat_luar +
                $biayasewaok +
                $akomodasi +
                $bagian_rs +
                $biaya_omloop +
                $biaya_omloop2 +
                $biaya_omloop3 +
                $biaya_omloop4 +
                $biaya_omloop5 +
                $biayasarpras +
                $biaya_dokter_pjanak +
                $biaya_dokter_umum,
        ];
        return response()->json($response, Response::HTTP_OK);
    }
    // 
    public function laboratorium()
    {
        $norawat = KamarInap::where('stts_pulang', '-')->distinct('no_rawat')->pluck('no_rawat');
        $biaya = Laboratorium::whereIn('no_rawat',  $norawat)->sum('biaya');
        $biaya_item = DetailPeriksaLab::whereIn('no_rawat',  $norawat)->sum('biaya_item');
        $response = [
            'success' => true,
            'message' => 'data list nomer rawat',
            'laborat' => $biaya + $biaya_item
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function tindakan()
    {
        $norawat = KamarInap::where('stts_pulang', '-')->distinct('no_rawat')->pluck('no_rawat');
        $layanandrpr = RawatJlDrprModel::whereIn('no_rawat',  $norawat)->sum('biaya_rawat');
        $layanandr = RawatJlDrModel::whereIn('no_rawat',  $norawat)->sum('biaya_rawat');
        $layananpr = RawatJlPrModel::whereIn('no_rawat',  $norawat)->sum('biaya_rawat');
        $umum = RawatInapPrModel::whereIn('no_rawat',  $norawat)->sum('biaya_rawat');
        $rawatInapDr = RawatInapDrModel::whereIn('no_rawat',  $norawat)->sum('biaya_rawat');
        $rawatInapDrPr = RawatInapDrprModel::whereIn('no_rawat',  $norawat)->sum('biaya_rawat');

        $response = [
            'success' => true,
            'message' => 'data list nomer rawat',
            'total' => $layanandr + $layanandrpr + $layananpr + $umum + $rawatInapDr + $rawatInapDrPr
            // 'total' => $rawatInapDr
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function total(string $jenislayanan,string $tanggal)
    {
        $idUmum = ['A01', 'A09', 'A46', 'A49'];
        $idBpjs = ['BPJ'];
        $cob = ['A02', 'A03', 'A07', 'A08', 'A10', 'A11', 'A12', 'A13', 'A14', 'A15', 'A16', 'A17', 'A18', 'A19', 'A20', 'A21', 'A22', 'A23', 'A24', 'A25', 'A26', 'A27', 'A28', 'A29', 'A30', 'A31', 'A32', 'A33', 'A34', 'A35', 'A36', 'A37', 'A38', 'A40', 'A42', 'A43', 'A45', 'A48', 'A50', 'A51', 'A52', 'A53', 'A54', 'A55', 'A58', 'A61', 'A62', 'A66', 'COB'];
        $kon = ['A05', 'A06', 'A44', 'A47', 'A56', 'A57', 'A60', 'A63', 'A64', 'A65'];
        $ketenagakerjaan= ['A04'];
        
        $dataJamKamar = Carbon::create($tanggal);

        $beforenorawat = KamarInap::where('stts_pulang', '-')->whereMonth('tgl_masuk', $dataJamKamar)->where('tgl_masuk','<=' ,$dataJamKamar)->distinct('no_rawat')->pluck('no_rawat');
        // $beforenorawat = KamarInap::where('stts_pulang', '-')->where('tgl_masuk', '>=', $tanggal)->distinct('no_rawat')->pluck('no_rawat');
        if ($jenislayanan==="umum") {
            $norawat = Periksa::whereIn('no_rawat',  $beforenorawat)->whereIn('kd_pj',$idUmum)->distinct('no_rawat')->pluck('no_rawat');
        }elseif ($jenislayanan==="bpjs") {
            $norawat = Periksa::whereIn('no_rawat',  $beforenorawat)->whereIn('kd_pj',$idBpjs)->distinct('no_rawat')->pluck('no_rawat');
        }elseif ($jenislayanan==="cob") {
            $norawat = Periksa::whereIn('no_rawat',  $beforenorawat)->whereIn('kd_pj',$cob)->distinct('no_rawat')->pluck('no_rawat');
        }elseif ($jenislayanan==="kon") {
            $norawat = Periksa::whereIn('no_rawat',  $beforenorawat)->whereIn('kd_pj',$kon)->distinct('no_rawat')->pluck('no_rawat');
        }elseif ($jenislayanan==="ketenagakerjaan") {
            $norawat = Periksa::whereIn('no_rawat',  $beforenorawat)->whereIn('kd_pj',$ketenagakerjaan)->distinct('no_rawat')->pluck('no_rawat');
        }else{
            $norawat = Periksa::whereIn('no_rawat',  $beforenorawat)->distinct('no_rawat')->pluck('no_rawat');
        }

        // kamarinap
        $kamars = KamarInap::where('stts_pulang', '-')->whereIn('no_rawat',  $norawat)->where('tgl_masuk', '<=', $tanggal)->get();
        $dateNow = Carbon::now();


        // revisi
        $totals = 0;
        foreach ($kamars as $kamar) {
            $dataJamKamar = Carbon::create($kamar->jam_masuk);
            $dataTanggalKamar = Carbon::create($kamar->tgl_masuk);
            $gabung = $dataTanggalKamar->setDate($dataTanggalKamar->year, $dataTanggalKamar->month, $dataTanggalKamar->day)->setTime($dataJamKamar->hour, $dataJamKamar->minute, $dataJamKamar->second);
            $gabungs = $dateNow->diff($gabung);

            if ($dateNow >  $gabung &&  $gabungs->h >= 6) {
                $totals = $totals + (($dateNow->diff($gabung)->days + 1) * $kamar->trf_kamar);
            } elseif ($dateNow >  $gabung &&  $gabungs->h < 6) {
                $totals = $totals +  ($dateNow->diff($gabung)->days * $kamar->trf_kamar);
            }
        }
  
      

        // regPeriksa()
        $listranap = RegPeriksaModel::whereIn('no_rawat',  $norawat)->sum('biaya_reg');

        //obat()
        $obat = Obat::whereIn('no_rawat',  $norawat)->sum('total');

        //radiology()
        $radiology = Radiologi::whereIn('no_rawat',  $norawat)->sum('biaya');

        //operasi
        $biayaoperator1 = Operasi::whereIn('no_rawat',  $norawat)->sum('biayaoperator1');
        $biayaoperator2 = Operasi::whereIn('no_rawat',  $norawat)->sum('biayaoperator2');
        $biayaoperator3 = Operasi::whereIn('no_rawat',  $norawat)->sum('biayaoperator3');
        $biayaasisten_operator1 = Operasi::whereIn('no_rawat',  $norawat)->sum('biayaasisten_operator1');
        $biayaasisten_operator2 = Operasi::whereIn('no_rawat',  $norawat)->sum('biayaasisten_operator2');
        $biayaasisten_operator3 = Operasi::whereIn('no_rawat',  $norawat)->sum('biayaasisten_operator3');
        $biayainstrumen = Operasi::whereIn('no_rawat',  $norawat)->sum('biayainstrumen');
        $dokter_anak = Operasi::whereIn('no_rawat',  $norawat)->sum('dokter_anak');
        $perawaat_resusitas  = Operasi::whereIn('no_rawat',  $norawat)->sum('perawaat_resusitas');
        $biayadokter_anestesi = Operasi::whereIn('no_rawat',  $norawat)->sum('biayadokter_anestesi');
        $biayaasisten_anestesi = Operasi::whereIn('no_rawat',  $norawat)->sum('biayaasisten_anestesi');
        $biayaasisten_anestesi2 = Operasi::whereIn('no_rawat',  $norawat)->sum('biayaasisten_anestesi2');
        $biayabidan = Operasi::whereIn('no_rawat',  $norawat)->sum('biayabidan');
        $biayabidan2 = Operasi::whereIn('no_rawat',  $norawat)->sum('biayabidan2');
        $biayabidan2 = Operasi::whereIn('no_rawat',  $norawat)->sum('biayabidan2');
        $biayabidan3 = Operasi::whereIn('no_rawat',  $norawat)->sum('biayabidan3');
        $biayaperawat_luar = Operasi::whereIn('no_rawat',  $norawat)->sum('biayaperawat_luar');
        $biayaalat = Operasi::whereIn('no_rawat',  $norawat)->sum('biayaalat');
        $biayasewaok = Operasi::whereIn('no_rawat',  $norawat)->sum('biayasewaok');
        $akomodasi = Operasi::whereIn('no_rawat',  $norawat)->sum('akomodasi');
        $bagian_rs = Operasi::whereIn('no_rawat',  $norawat)->sum('bagian_rs');
        $biaya_omloop = Operasi::whereIn('no_rawat',  $norawat)->sum('biaya_omloop');
        $biaya_omloop2 = Operasi::whereIn('no_rawat',  $norawat)->sum('biaya_omloop2');
        $biaya_omloop3 = Operasi::whereIn('no_rawat',  $norawat)->sum('biaya_omloop3');
        $biaya_omloop4 = Operasi::whereIn('no_rawat',  $norawat)->sum('biaya_omloop4');
        $biaya_omloop5 = Operasi::whereIn('no_rawat',  $norawat)->sum('biaya_omloop3');
        $biayasarpras = Operasi::whereIn('no_rawat',  $norawat)->sum('biayasarpras');
        $biaya_dokter_pjanak = Operasi::whereIn('no_rawat',  $norawat)->sum('biaya_dokter_pjanak');
        $biaya_dokter_umum = Operasi::whereIn('no_rawat',  $norawat)->sum('biaya_dokter_umum');

        //lab
        $biayalab = Laboratorium::whereIn('no_rawat',  $norawat)->sum('biaya');
        $biaya_item_lab = DetailPeriksaLab::whereIn('no_rawat',  $norawat)->sum('biaya_item');

        // tindakan()
        $layanandrpr = RawatJlDrprModel::whereIn('no_rawat',  $norawat)->sum('biaya_rawat');
        $layanandr = RawatJlDrModel::whereIn('no_rawat',  $norawat)->sum('biaya_rawat');
        $layananpr = RawatJlPrModel::whereIn('no_rawat',  $norawat)->sum('biaya_rawat');
        $umum = RawatInapPrModel::whereIn('no_rawat',  $norawat)->sum('biaya_rawat');
        $rawatInapDr = RawatInapDrModel::whereIn('no_rawat',  $norawat)->sum('biaya_rawat');
        $rawatInapDrPr = RawatInapDrprModel::whereIn('no_rawat',  $norawat)->sum('biaya_rawat');

        $totalbiayakeseluruhan = $listranap +
            //TINDAKAN
            $layanandr + $layanandrpr + $layananpr + $umum + $rawatInapDr + $rawatInapDrPr +
            //OBAT
            $obat +
            //LAB
            $biayalab + $biaya_item_lab +
            //RADIOLOGI
            $radiology +
            //KAMAR
            $totals +
            //OPERASI
            $biayaoperator1 +
            $biayaoperator2 +
            $biayaoperator3 +
            $biayaasisten_operator1 +
            $biayaasisten_operator2 +
            $biayaasisten_operator3 +
            $biayainstrumen +
            $dokter_anak +
            $perawaat_resusitas +
            $biayadokter_anestesi +
            $biayaasisten_anestesi +
            $biayaasisten_anestesi2 +
            $biayabidan +
            $biayabidan2 +
            $biayabidan3 +
            $biayaalat +
            $biayaperawat_luar +
            $biayasewaok +
            $akomodasi +
            $bagian_rs +
            $biaya_omloop +
            $biaya_omloop2 +
            $biaya_omloop3 +
            $biaya_omloop4 +
            $biaya_omloop5 +
            $biayasarpras +
            $biaya_dokter_pjanak +
            $biaya_dokter_umum;

        $response = [
            'success' => true,
            'message' => 'data tentang kami',
            'registrasi' => $listranap,
            'tindakan' => $layanandr + $layanandrpr + $layananpr + $umum + $rawatInapDr + $rawatInapDrPr,
            'obat' => $obat,
            'lab' => $biayalab + $biaya_item_lab,
            'radiologi' => $radiology,
            'kamar' => $totals,
            'operasi' => $biayaoperator1 +
                $biayaoperator2 +
                $biayaoperator3 +
                $biayaasisten_operator1 +
                $biayaasisten_operator2 +
                $biayaasisten_operator3 +
                $biayainstrumen +
                $dokter_anak +
                $perawaat_resusitas +
                $biayadokter_anestesi +
                $biayaasisten_anestesi +
                $biayaasisten_anestesi2 +
                $biayabidan +
                $biayabidan2 +
                $biayabidan3 +
                $biayaalat +
                $biayaperawat_luar +
                $biayasewaok +
                $akomodasi +
                $bagian_rs +
                $biaya_omloop +
                $biaya_omloop2 +
                $biaya_omloop3 +
                $biaya_omloop4 +
                $biaya_omloop5 +
                $biayasarpras +
                $biaya_dokter_pjanak +
                $biaya_dokter_umum,

            'total' =>
            //periksa
            $listranap +
                //TINDAKAN
                $layanandr + $layanandrpr + $layananpr + $umum + $rawatInapDr + $rawatInapDrPr +
                //OBAT
                $obat +
                //LAB
                $biayalab + $biaya_item_lab +
                //RADIOLOGI
                $radiology +
                //KAMAR
                $totals +
                //OPERASI
                $biayaoperator1 +
                $biayaoperator2 +
                $biayaoperator3 +
                $biayaasisten_operator1 +
                $biayaasisten_operator2 +
                $biayaasisten_operator3 +
                $biayainstrumen +
                $dokter_anak +
                $perawaat_resusitas +
                $biayadokter_anestesi +
                $biayaasisten_anestesi +
                $biayaasisten_anestesi2 +
                $biayabidan +
                $biayabidan2 +
                $biayabidan3 +
                $biayaalat +
                $biayaperawat_luar +
                $biayasewaok +
                $akomodasi +
                $bagian_rs +
                $biaya_omloop +
                $biaya_omloop2 +
                $biaya_omloop3 +
                $biaya_omloop4 +
                $biaya_omloop5 +
                $biayasarpras +
                $biaya_dokter_pjanak +
                $biaya_dokter_umum,
            'data_angka' => $array[] = [
                $listranap,
                $layanandr + $layanandrpr + $layananpr + $umum + $rawatInapDr + $rawatInapDrPr,
                $obat,
                $biayalab + $biaya_item_lab,
                $radiology,
                $totals,
                $biayaoperator1 +
                    $biayaoperator2 +
                    $biayaoperator3 +
                    $biayaasisten_operator1 +
                    $biayaasisten_operator2 +
                    $biayaasisten_operator3 +
                    $biayainstrumen +
                    $dokter_anak +
                    $perawaat_resusitas +
                    $biayadokter_anestesi +
                    $biayaasisten_anestesi +
                    $biayaasisten_anestesi2 +
                    $biayabidan +
                    $biayabidan2 +
                    $biayabidan3 +
                    $biayaalat +
                    $biayaperawat_luar +
                    $biayasewaok +
                    $akomodasi +
                    $bagian_rs +
                    $biaya_omloop +
                    $biaya_omloop2 +
                    $biaya_omloop3 +
                    $biaya_omloop4 +
                    $biaya_omloop5 +
                    $biayasarpras +
                    $biaya_dokter_pjanak +
                    $biaya_dokter_umum,
            ],
            'data_label' => $array[] = [
                'Registrasi', 'Tindakan', 'Obat', 'Laborat', 'Radiologi', 'Kamar', 'Operasi'
            ],
        ];
        return response()->json($response, Response::HTTP_OK);
    }
}
