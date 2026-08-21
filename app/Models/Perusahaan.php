<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    protected $table = 'perusahaans';

    protected $fillable = [
        'nama_perusahaan',
        'alamat',
        'kontak',
        'email',
        'status'
    ];

    public function proyek()
    {
        return $this->hasMany(
            Proyek::class,
            'perusahaan_id'
        );
    }
}