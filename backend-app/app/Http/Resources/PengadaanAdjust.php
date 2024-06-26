<?php

namespace App\Http\Resources;

use App\Models\SaldoAwalModel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PengadaanAdjust extends JsonResource
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
            'nama_bulan' => $this->nama_bulan,
            'total_data' => SaldoAwalModel::where('nama_bulan',$this->nama_bulan )->count(),
        ];
    }
}
