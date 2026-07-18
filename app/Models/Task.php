<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     * Ini memastikan Laravel mengizinkan data masuk ke kolom-kolom ini.
     */
    protected $fillable = [
    'project_id',
    'division_id',
    'employee_id',
    'tanggal',
    'nama_task',
    'aktivitas',
    'prioritas',
    'deadline',
    'status',
    'progress_persen',
    'catatan',
];

    // --- RELASI (Menghubungkan Task dengan tabel lain) ---

    // Setiap Task milik satu Proyek
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Setiap Task dikerjakan oleh satu Divisi
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    // Setiap Task dipegang oleh satu Karyawan (PIC)
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function activities()
{
    return $this->hasMany(TaskActivity::class);
}

public function updateStatus()
{
    if($this->progress_persen >= 100){

        $this->status = 'done';

    }elseif($this->progress_persen > 0){

        $this->status = 'progress';

    }else{

        $this->status = 'todo';

    }


    $this->save();
}
}