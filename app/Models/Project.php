<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function deposits()
    {
        return $this->hasMany(ProjectDeposit::class);
    }

public function allocations()
{

    return $this->hasMany(
        ProjectDivisionAllocation::class
    );

}

    // Hitung progress keseluruhan project
    public function getProgressKeseluruhanAttribute()
    {
        if ($this->tasks->count() == 0) {
            return 0;
        }

        return round(
            $this->tasks->avg('progress_persen')
        );
    }
    
}