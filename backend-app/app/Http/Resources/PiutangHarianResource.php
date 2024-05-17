<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PiutangHarianResource extends JsonResource
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
            'id' => $this->id,
            'total' =>  number_format($this->harian, 0, ',', '.'),
            'tanggal' => Carbon::parse($this->created_at)->format('d-M-y'),
            'jam_update' => Carbon::parse($this->created_at)->format('H:i:s'),
        ];
    }
}
