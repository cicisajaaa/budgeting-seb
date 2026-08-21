<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Tugas;
use App\Models\AktivitasTugas;
use App\Models\User;
use App\Models\Perusahaan;
use App\Models\PengajuanDana;
use App\Models\TransaksiDana;
use App\Models\SetoranProyek;
use App\Models\AlokasiProyekDivisi;
use App\Models\SaldoDivisi;




class Proyek extends Model
{


    protected $table = 'proyek';



    protected $fillable = [

        'perusahaan_id',

        'nama_proyek',

        'tanggal_mulai',

        'tanggal_selesai',

        'pemilik_proyek',

        'total_anggaran',

    ];



    protected $casts = [

        'total_anggaran'=>'decimal:2',

        'tanggal_mulai'=>'date',

        'tanggal_selesai'=>'date',

    ];

    protected $with = [

        'perusahaan'

    ];


    /*
    |--------------------------------------------------------------------------
    | Relasi Perusahaan
    |--------------------------------------------------------------------------
    */


    public function perusahaan()
    {

        return $this->belongsTo(

            Perusahaan::class,

            'perusahaan_id'

        );

    }




    /*
    |--------------------------------------------------------------------------
    | Relasi Tugas
    |--------------------------------------------------------------------------
    */


    public function tugas()
    {

        return $this->hasMany(

            Tugas::class,

            'proyek_id'

        );

    }




    /*
    |--------------------------------------------------------------------------
    | Relasi Aktivitas Tugas
    |--------------------------------------------------------------------------
    */


    public function aktivitasTugas()
    {

        return $this->hasManyThrough(

            AktivitasTugas::class,

            Tugas::class,

            'proyek_id',

            'tugas_id'

        );

    }




    /*
    |--------------------------------------------------------------------------
    | Total Anggaran Aktivitas
    |--------------------------------------------------------------------------
    */


    public function getTotalAnggaranAktivitasAttribute()
    {

        return $this->aktivitasTugas()

            ->sum('anggaran_aktivitas');

    }





    /*
    |--------------------------------------------------------------------------
    | Relasi Setoran Proyek
    |--------------------------------------------------------------------------
    */


    public function setoranProyek()
    {

        return $this->hasMany(

            SetoranProyek::class,

            'proyek_id'

        );

    }




    /*
    |--------------------------------------------------------------------------
    | Relasi Alokasi Divisi
    |--------------------------------------------------------------------------
    */


    public function alokasiDivisi()
    {

        return $this->hasMany(

            AlokasiProyekDivisi::class,

            'proyek_id'

        );

    }




    /*
    |--------------------------------------------------------------------------
    | Relasi Saldo Divisi
    |--------------------------------------------------------------------------
    */


    public function saldoDivisi()
    {

        return $this->hasMany(

            SaldoDivisi::class,

            'proyek_id'

        );

    }




    /*
    |--------------------------------------------------------------------------
    | Relasi Pengajuan Dana
    |--------------------------------------------------------------------------
    */


    public function pengajuanDana()
    {

        return $this->hasMany(

            PengajuanDana::class,

            'proyek_id'

        );

    }




/*
|--------------------------------------------------------------------------
| Relasi Transaksi Dana melalui Pengajuan Dana
|--------------------------------------------------------------------------
*/

public function transaksiDana()
{

    return $this->hasManyThrough(

        TransaksiDana::class,

        PengajuanDana::class,

        'proyek_id',              // FK di tabel pengajuan_dana

        'pengajuan_dana_id',      // FK di tabel transaksi_dana

        'id',                     // PK tabel proyek

        'id'                      // PK tabel pengajuan_dana

    );

}




    /*
    |--------------------------------------------------------------------------
    | Total Realisasi Dana
    |--------------------------------------------------------------------------
    */

        public function getTotalRealisasiAttribute()
        {

            return (float) $this->transaksiDana()
                ->sum('transaksi_dana.jumlah');

        }





    /*
    |--------------------------------------------------------------------------
    | Sisa Budget Proyek
    |--------------------------------------------------------------------------
    */


    public function getSisaBudgetAttribute()
    {

        return $this->total_anggaran -

               $this->total_realisasi;

    }




public function getSisaAnggaranAttribute()
{
    return $this->sisa_budget;
}
    /*
    |--------------------------------------------------------------------------
    | Persentase Budget Terpakai
    |--------------------------------------------------------------------------
    */


    public function getPersentaseBudgetAttribute()
    {


        if($this->total_anggaran == 0)
        {

            return 0;

        }



        return round(

            ($this->total_realisasi /

            $this->total_anggaran) * 100

        );


    }



/*
|--------------------------------------------------------------------------
| Sisa Budget Persentase
|--------------------------------------------------------------------------
*/

public function getSisaPersentaseAttribute()
{

    if($this->total_anggaran <= 0)
    {
        return 0;
    }


    return round(
        ($this->sisa_budget /
        $this->total_anggaran) * 100
    );

}
    /*
    |--------------------------------------------------------------------------
    | Status Budget
    |--------------------------------------------------------------------------
    */


    public function getStatusBudgetAttribute()
    {


        if($this->persentase_budget >= 90)
        {

            return 'Hampir Habis';

        }



        if($this->persentase_budget >= 75)
        {

            return 'Perhatian';

        }



        return 'Aman';

    }


/*
|--------------------------------------------------------------------------
| Status Keuangan Proyek
|--------------------------------------------------------------------------
*/

public function getStatusKeuanganAttribute()
{

    if($this->sisa_budget <= 0)
    {
        return 'Budget Habis';
    }


    if($this->persentase_budget >= 90)
    {
        return 'Kritis';
    }


    if($this->persentase_budget >= 75)
    {
        return 'Perlu Pengawasan';
    }


    return 'Normal';

}


    /*
    |--------------------------------------------------------------------------
    | Progress Proyek Otomatis
    |--------------------------------------------------------------------------
    */


    public function getProgresKeseluruhanAttribute()
    {


        $totalTugas = $this->tugas()->count();



        if($totalTugas == 0)
        {

            return 0;

        }



        return round(

            $this->tugas()

            ->avg('progres_persen')

        );


    }





    /*
    |--------------------------------------------------------------------------
    | Status Project
    |--------------------------------------------------------------------------
    */


    public function getStatusProjectAttribute()
    {


        if($this->progres_keseluruhan >= 100)
        {

            return 'Selesai';

        }



        if($this->progres_keseluruhan > 0)
        {

            return 'Berjalan';

        }



        return 'Belum Dimulai';


    }



public function transaksi()
{

    return $this->transaksiDana();

}


/*
|--------------------------------------------------------------------------
| Status Deadline
|--------------------------------------------------------------------------
*/

public function getDeadlineStatusAttribute()
{

    if(!$this->tanggal_selesai)
    {
        return 'normal';
    }


    if(now()->gt($this->tanggal_selesai))
    {
        return 'terlambat';
    }


    return 'normal';

}




/*
|--------------------------------------------------------------------------
| Status Kesehatan Proyek
|--------------------------------------------------------------------------
*/

public function getHealthStatusAttribute()
{

    $progress = $this->progres_keseluruhan;

    $budget = $this->persentase_budget;



    /*
    |--------------------------------------------------------------------------
    | Kondisi Kritis
    |--------------------------------------------------------------------------
    */

    if(
        $budget >= 90 ||
        (
            $progress < 50 &&
            $this->deadline_status == 'terlambat'
        )
    )
    {

return [

'label'=>'Kritis',

'color'=>'kritis',

'icon'=>'🔴'

];
    }




    /*
    |--------------------------------------------------------------------------
    | Kondisi Perhatian
    |--------------------------------------------------------------------------
    */

    if(

        $budget >= 75 ||

        $progress < 50

    )
    {

return [

'label'=>'Perhatian',

'color'=>'perhatian',

'icon'=>'🟡'

];
    }




    /*
    |--------------------------------------------------------------------------
    | Kondisi Aman
    |--------------------------------------------------------------------------
    */

    return [

        'label'=>'Aman',

        'color'=>'aman',

        'icon'=>'🟢'

    ];


}

    /*
    |--------------------------------------------------------------------------
    | Relasi Anggota Project
    |--------------------------------------------------------------------------
    */


    public function users()
    {

        return $this->belongsToMany(

            User::class,

            'project_user',

            'proyek_id',

            'user_id'

        );

    }



}