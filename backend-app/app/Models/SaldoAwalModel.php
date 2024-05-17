<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaldoAwalModel extends Model
{
    use HasFactory;
    protected $table = "ext_saldo_awal";
    // protected $connection = 'mysql2';
    protected $guarded =[];
    public $timestamps = false;

    public function jenisbarang(): BelongsTo
    {
        return $this->belongsTo(Jenisbarang::class, 'kdjns', 'kdjns');
    }
}
