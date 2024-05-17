<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PengadaanResource extends JsonResource
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
            'kode_brng' => $this->kode_brng,
            'nama_brng' => $this->nama_brng,
            'kode_satbesar' => $this->kode_satbesar,
            'kode_sat' => $this->kode_sat,
            'key'=> $this->kode_brng,
            'value' =>$this->kode_brng,
            'text'=>$this->kode_brng.' - '. $this->nama_brng,
        ];
        
    }
}
