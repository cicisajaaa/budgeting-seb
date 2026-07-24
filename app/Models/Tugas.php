<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


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
    | Update Status Otomatis
    |--------------------------------------------------------------------------
    */


    public function updateStatus()
{


    if($this->progres_persen >= 100)
    {

        $this->status = 'selesai';

    }
    elseif($this->progres_persen > 0)
    {

        $this->status = 'sedang_dikerjakan';

    }
    else
    {

        $this->status = 'belum_dikerjakan';

    }


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


        $tenggat = \Carbon\Carbon::parse(

            $this->deadline

        );







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




}