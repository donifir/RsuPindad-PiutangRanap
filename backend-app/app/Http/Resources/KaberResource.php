<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KaberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'no_reg' => $this->no_reg,
            'no_rawat' => $this->no_rawat,
            'no_rkm_medis' => $this->no_rkm_medis,
            'tgl_ranap' => $this->kamarInap->tgl_masuk,
            'kd_kamar' => $this->kamarInap->kd_kamar,
            'no_telp' => $this->pasien->no_tlp,
            'alamat' => $this->pasien->alamat,
            'nama_pasien'=>$this->pasien->nm_pasien,
            'nik'=>$this->pasien->no_ktp
        ];
    }
}
