<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Proyek;
use App\Models\Divisi;
use App\Models\Karyawan;
use App\Models\AktivitasTugas;



class Tugas extends Model
{


    protected $table = 'tugas';




    protected $fillable = [

        'proyek_id',

        'divisi_id',

        'karyawan_id',

        'tanggal',

        'nama_tugas',

        'aktivitas',

        'prioritas',

        'deadline',

        'status',

        'progres_persen',

        'catatan',

    ];





    /*
    |--------------------------------------------------------------------------
    | DEFAULT VALUE
    |--------------------------------------------------------------------------
    */

    protected $attributes = [

        'status'=>'belum_dikerjakan',

        'progres_persen'=>0

    ];





    protected $casts = [

        'tanggal'=>'date',

        'deadline'=>'date',

        'progres_persen'=>'decimal:2',

    ];








    /*
    |--------------------------------------------------------------------------
    | AUTO STATUS BERDASARKAN PROGRESS
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {

        static::saving(function($task){


            /*
            |--------------------------------------------------------------------------
            | JIKA DIBATALKAN JANGAN DIUBAH OTOMATIS
            |--------------------------------------------------------------------------
            */

            if($task->status === 'dibatalkan')
            {

                return;

            }




            $progress = $task->progres_persen ?? 0;




            if($progress >= 100)
            {

                $task->status = 'selesai';

            }

            elseif($progress > 0)
            {

                $task->status = 'sedang_dikerjakan';

            }

            else
            {

                $task->status = 'belum_dikerjakan';

            }



        });


    }









    /*
    |--------------------------------------------------------------------------
    | RELASI PROJECT
    |--------------------------------------------------------------------------
    */

    public function proyek()
    {

        return $this->belongsTo(

            Proyek::class,

            'proyek_id'

        );

    }









    /*
    |--------------------------------------------------------------------------
    | RELASI DIVISI
    |--------------------------------------------------------------------------
    */

    public function divisi()
    {

        return $this->belongsTo(

            Divisi::class,

            'divisi_id'

        );

    }









    /*
    |--------------------------------------------------------------------------
    | RELASI KARYAWAN
    |--------------------------------------------------------------------------
    */

    public function karyawan()
    {

        return $this->belongsTo(

            Karyawan::class,

            'karyawan_id'

        );

    }









    /*
    |--------------------------------------------------------------------------
    | RELASI AKTIVITAS
    |--------------------------------------------------------------------------
    */

    public function aktivitasTugas()
    {

        return $this->hasMany(

            AktivitasTugas::class,

            'tugas_id'

        );

    }









    /*
    |--------------------------------------------------------------------------
    | UPDATE PROGRESS DARI AKTIVITAS TERAKHIR
    |--------------------------------------------------------------------------
    */

    public function updateProgress()
    {


        if($this->status == 'dibatalkan')
        {

            return;

        }




        $aktivitasTerakhir = $this->aktivitasTugas()

            ->latest('tanggal')

            ->first();





        $this->progres_persen = $aktivitasTerakhir

            ? $aktivitasTerakhir->progres

            : 0;





        $this->save();


    }









    /*
    |--------------------------------------------------------------------------
    | AKTIVITAS TERAKHIR
    |--------------------------------------------------------------------------
    */

    public function getAktivitasTerakhirAttribute()
    {


        return $this->aktivitasTugas()

            ->latest('tanggal')

            ->first();


    }









    /*
    |--------------------------------------------------------------------------
    | STATUS DEADLINE
    |--------------------------------------------------------------------------
    */

    public function getDeadlineStatusAttribute()
    {


        if(!$this->deadline)
        {

            return [

                'label'=>'Tidak Ada Deadline',

                'color'=>'secondary'

            ];

        }




        if($this->status=='selesai')
        {

            return [

                'label'=>'Selesai',

                'color'=>'success'

            ];

        }





        if(now()->gt($this->deadline))
        {

            return [

                'label'=>'Terlambat',

                'color'=>'danger'

            ];

        }





        if(now()->diffInDays($this->deadline)<=3)
        {

            return [

                'label'=>'Mendekati Deadline',

                'color'=>'warning'

            ];

        }





        return [

            'label'=>'Aman',

            'color'=>'success'

        ];


    }









    /*
    |--------------------------------------------------------------------------
    | STATUS PROGRESS
    |--------------------------------------------------------------------------
    */

    public function getStatusProgressAttribute()
    {


        if($this->status == 'dibatalkan')
        {

            return 'Dibatalkan';

        }





        if(($this->progres_persen ?? 0) >= 100)
        {

            return 'Selesai';

        }





        if(($this->progres_persen ?? 0) > 0)
        {

            return 'Berjalan';

        }





        return 'Belum Dimulai';


    }




}