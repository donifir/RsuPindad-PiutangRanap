<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KamarInap extends Model
{
    use HasFactory;
    protected $table = "kamar_inap";

    public function periksa(): BelongsTo
    {
        return $this->belongsTo(Periksa::class, 'no_rawat', 'no_rawat');
    }
    public function penanggungjawab(): BelongsTo
    {
        return $this->belongsTo(PenanggungJawabModel::class, 'kd_pj', 'kd_pj');
    }

    // tindakan
    public function rawatJlDrprModel(): BelongsTo
    {
        return $this->belongsTo(RawatJlDrprModel::class, 'no_rawat', 'no_rawat');
    }
    public function RawatJlDrModel(): BelongsTo
    {
        return $this->belongsTo(RawatJlDrModel::class, 'no_rawat', 'no_rawat');
    }
    public function RawatJlPrModel(): BelongsTo
    {
        return $this->belongsTo(RawatJlPrModel::class, 'no_rawat', 'no_rawat');
    }
    public function RawatInapPrModel(): BelongsTo
    {
        return $this->belongsTo(RawatInapPrModel::class, 'no_rawat', 'no_rawat');
    }
    public function RawatInapDrModel(): BelongsTo
    {
        return $this->belongsTo(RawatInapDrModel::class, 'no_rawat', 'no_rawat');
    }
    public function RawatInapDrprModel(): BelongsTo
    {
        return $this->belongsTo(RawatInapDrprModel::class, 'no_rawat', 'no_rawat');
    }
}
