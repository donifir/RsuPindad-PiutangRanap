<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RanapResource extends JsonResource
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
            'norm' => $this->pasien->no_rkm_medis,
            'penanggungjawab' => $this->penanggungjawab->png_jawab,
            'tgl_masuk' => $this->kamarInap->tgl_masuk,
            // 'date_now' => Carbon::now()->format("h:i:s"),
           
        ];
    }
}
