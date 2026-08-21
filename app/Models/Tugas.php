<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Proyek;
use App\Models\Divisi;
use App\Models\Karyawan;
use App\Models\AktivitasTugas;

use Carbon\Carbon;


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



    protected $casts = [

        'tanggal' => 'date',

        'deadline' => 'date',

    ];



    /*
    |--------------------------------------------------------------------------
    | Update Status Otomatis
    |--------------------------------------------------------------------------
    */


    protected static function booted()
    {

        static::saving(function ($task) {


            if($task->progres_persen >= 100)
            {

                $task->status = 'selesai';

            }

            elseif($task->progres_persen > 0)
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
    | Relasi Proyek
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
    | Relasi Divisi
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
    | Relasi Karyawan
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
    | Relasi Aktivitas Tugas
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
    | Update Progress dari Aktivitas
    |--------------------------------------------------------------------------
    */


    public function updateProgress()
    {

        $progress = $this->aktivitasTugas()

            ->max('progres');



        $this->progres_persen = $progress ?? 0;


        $this->save();


    }







    /*
    |--------------------------------------------------------------------------
    | Status Deadline
    |--------------------------------------------------------------------------
    */


    public function statusDeadline()
    {


        if(!$this->deadline)
        {

            return [

                'label'=>'Tidak Ada Tenggat',

                'color'=>'secondary'

            ];

        }





        $hariIni = now();


        $tenggat = Carbon::parse(

            $this->deadline

        );







        if($this->status == 'selesai')
        {

            return [

                'label'=>'Selesai',

                'color'=>'success'

            ];

        }







        if($hariIni->gt($tenggat))
        {

            return [

                'label'=>'Terlambat',

                'color'=>'danger'

            ];

        }







        if($hariIni->diffInDays($tenggat) <= 3)
        {

            return [

                'label'=>'Mendekati Tenggat',

                'color'=>'warning'

            ];

        }







        return [

            'label'=>'Normal',

            'color'=>'success'

        ];


    }








    /*
    |--------------------------------------------------------------------------
    | Accessor Status Progress
    |--------------------------------------------------------------------------
    */


    public function getStatusProgressAttribute()
    {


        if($this->progres_persen >= 100)
        {

            return 'Selesai';

        }



        if($this->progres_persen > 0)
        {

            return 'Berjalan';

        }



        return 'Belum Dimulai';


    }





}