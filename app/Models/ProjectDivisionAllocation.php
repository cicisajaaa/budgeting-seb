<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectDivisionAllocation extends Model
{
    // Mengizinkan semua kolom diisi data
    protected $guarded = [];

    // Relasi ke tabel Project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Relasi ke tabel Division
    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}