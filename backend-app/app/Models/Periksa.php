<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Periksa extends Model
{
    use HasFactory;
    protected $table = "reg_periksa";
    public function penanggungjawab(): BelongsTo
    {
        return $this->belongsTo(PenanggungJawabModel::class, 'kd_pj', 'kd_pj');
    }
    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class, 'no_rkm_medis', 'no_rkm_medis');
    }
    public function kamarInap(): BelongsTo
    {
        return $this->belongsTo(KamarInap::class, 'no_rawat', 'no_rawat');
    }
    public function sep(): BelongsTo
    {
        return $this->belongsTo(SepModel::class, 'no_rawat', 'no_rawat');
    }
    public function poliklinik(): BelongsTo
    {
        return $this->belongsTo(PoliklinikModel::class, 'kd_poli', 'kd_poli');
    }
    
}
