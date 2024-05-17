<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pasien extends Model
{
    use HasFactory;
    protected $table = "pasien";
    
    public function periksa(): BelongsTo
    {
        return $this->belongsTo(Periksa::class, 'no_rawat', 'no_rawat');
    }
    public function kamarInap(): BelongsTo
    {
        return $this->belongsTo(KamarInap::class, 'no_rawat', 'no_rawat');
    }
}
