<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegPeriksaModel extends Model
{
    use HasFactory;
    protected $table = "reg_periksa";
    public function kamarInap(): BelongsTo
    {
        return $this->belongsTo(KamarInap::class, 'no_rawat', 'no_rawat');
    }
}
