<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Databarang extends Model
{
    use HasFactory;
    protected $table = "databarang";
    public function industri(): BelongsTo
    {
        return $this->belongsTo(IndustriFarmasi::class, 'kode_industri', 'kode_industri');
    }
    public function jenisbarang(): BelongsTo
    {
        return $this->belongsTo(Jenisbarang::class, 'kdjns', 'kdjns');
    }
}
