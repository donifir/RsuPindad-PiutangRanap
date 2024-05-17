<?php

namespace App\Http\Resources;

use App\Models\RawatJlDrModel;
use App\Models\RawatJlDrprModel;
use App\Models\RawatJlPrModel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TindakanResource extends JsonResource
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
            'RawatJlDrprModel'=>$this->no_rawat,
            'RawatJlDrModel'=>$this->no_rawat,
            'RawatJlPrModel'=>$this->no_rawat

            // 'norm' => $this->pasien->no_rkm_medis,
        ];
    }
    public function with($request)
    {
        return [
            'RawatJlDrprModel' => RawatJlDrprModel::where('no_rawat', $this->no_rawat)->get(),
            'RawatJlDrModel' => RawatJlDrModel::where('no_rawat', $this->no_rawat)->get(),
            'RawatJlPrModel'=>RawatJlPrModel::where('no_rawat', $this->no_rawat)->get(),
        ];
    }
   
}
