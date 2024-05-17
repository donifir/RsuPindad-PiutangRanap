<?php

namespace App\Http\Resources;

use App\Models\SaldoAwalModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class PenerimaanObatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
    
        return [
            // 'id'=>$this->id,
            'kode_brng' => $this->kode_brng??'',
            'nama_brng' => $this->nama_brng??'',
            'kategori' => $this->jenisbarang??'',
            'qty_saldo_awal' => $this->qty_saldo_awal??'',
            'harsat_saldo_awal' => $this->harsat_saldo_awal??'',
            'nilai_saldo_awal' => $this->nilai_saldo_awal??'',
            'qty_penerimaan' =>   $this->qty_penerimaan??'',
            'total_penerimaan' =>   $this->total_penerimaan??'',
            'qty_retur' => $this->qty_retur??'',
            'qty_pengeluaran' => $this->qty_pengeluaran??'',

        ];
    }
}
