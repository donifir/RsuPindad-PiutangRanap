<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SepResource extends JsonResource
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
            'no_rawat' => $this->no_rawat,
            'pasien' => $this->pasien->nm_pasien,
            'poli' => $this->poliklinik->nm_poli??'',
            'norm' => $this->pasien->no_rkm_medis,
            'penanggungjawab' => $this->penanggungjawab->png_jawab,
            'tgl_registrasi' => $this->tgl_registrasi,
            'no_sep' => $this->sep->no_sep??"-",
           
        ];
    }
}
