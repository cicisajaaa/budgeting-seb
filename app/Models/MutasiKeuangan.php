<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MutasiKeuangan extends Model
{
    protected $table = 'mutasi_keuangan';

    protected $fillable = [
        'rekening_bank_id',
        'jenis',
        'nominal',
        'referensi_type',
        'referensi_id',
        'tanggal',
        'keterangan',
        'created_by',
    ];

    protected $casts = [
        'nominal' => 'decimal:2',
        'tanggal' => 'date',
    ];

    public function rekeningBank()
    {
        return $this->belongsTo(
            RekeningBank::class,
            'rekening_bank_id'
        );
    }

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }
}