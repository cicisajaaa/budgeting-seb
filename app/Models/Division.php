<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    // Mengizinkan semua kolom diisi data
    protected $guarded = [];

    // (Opsional) Relasi ke tabel Task, jika divisi ini punya banyak task
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    // (Opsional) Relasi ke tabel Employee, jika divisi ini punya banyak karyawan
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
    public function distributions()
{
    return $this->hasMany(
        DepositDistribution::class
    );
}
}