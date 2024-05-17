<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TelpResource extends JsonResource
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
            'no_rkm_medis' => $this->no_rkm_medis,
            'nm_pasien'=>$this->nm_pasien,
            'no_tlp'=>$this->no_tlp,
            'norawat'=>$this->kamarInap->no_rawat,
            // 'norm' => $this->pasien->no_rkm_medis,
        ];
    }
}
