<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JppkResource extends JsonResource
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
            'nama' => $this->pasien->nm_pasien,
            'no_ktp' => $this->pasien->no_ktp,
        ];
    }
}
