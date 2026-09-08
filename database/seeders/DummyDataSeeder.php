<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Proyek;
use App\Models\Karyawan;
use App\Models\Tugas;
use App\Models\AlokasiProyekDivisi;

use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;



class DummyDataSeeder extends Seeder
{

    public function run(): void
    {


        /*
        |--------------------------------------------------------------------------
        | 1. DATA USER
        |--------------------------------------------------------------------------
        */


        $users = [

            [
                'name'=>'TIRA',
                'email'=>'tira@gmail.com',
                'password'=>Hash::make('password')
            ],

            [
                'name'=>'NAYA',
                'email'=>'naya@gmail.com',
                'password'=>Hash::make('password')
            ],

            [
                'name'=>'BELA',
                'email'=>'bela@gmail.com',
                'password'=>Hash::make('password')
            ],

            [
                'name'=>'RAUDAH',
                'email'=>'raudah@gmail.com',
                'password'=>Hash::make('password')
            ],

            [
                'name'=>'SYIFA',
                'email'=>'syifa@gmail.com',
                'password'=>Hash::make('password')
            ],

            [
                'name'=>'YUNICA',
                'email'=>'yunica@gmail.com',
                'password'=>Hash::make('password')
            ],

            [
                'name'=>'YASMIN',
                'email'=>'yasmin@gmail.com',
                'password'=>Hash::make('password')
            ],

            [
                'name'=>'MAULIDA',
                'email'=>'maulida@gmail.com',
                'password'=>Hash::make('password')
            ],

            [
                'name'=>'AUREL',
                'email'=>'aurel@gmail.com',
                'password'=>Hash::make('password')
            ],

            [
                'name'=>'ASRIN',
                'email'=>'asrin@gmail.com',
                'password'=>Hash::make('password')
            ],

        ];


$userIds = [];

foreach($users as $user)
{

    $data = User::firstOrCreate(
        [
            'email'=>$user['email']
        ],
        $user
    );


    $userIds[$data->name] = $data->id;

}





        /*
        |--------------------------------------------------------------------------
        | 2. DATA PROYEK
        |--------------------------------------------------------------------------
        */


        $projects = [

            [
                'nama_proyek'=>'CV BERDIKARI',
                'anggaran'=>150000000
            ],

            [
                'nama_proyek'=>'CV SUNFAN JAYA PERSADA',
                'anggaran'=>50000000
            ],

            [
                'nama_proyek'=>'CV TIGA SERANGKAI BINUANG',
                'anggaran'=>80000000
            ],

            [
                'nama_proyek'=>'PT BERKAT BERSUJUD',
                'anggaran'=>120000000
            ],

            [
                'nama_proyek'=>'PT BANDANGAN TIRTA AGUNG',
                'anggaran'=>90000000
            ],

            [
                'nama_proyek'=>'PT PLANTINDO AGRO SUBUR',
                'anggaran'=>200000000
            ],

            [
                'nama_proyek'=>'PT DORISFA GUNUNG MULIA',
                'anggaran'=>150000000
            ],

            [
                'nama_proyek'=>'DINAS PERTANIAN KAB KAPUAS (RPU)',
                'anggaran'=>50000000
            ]

        ];



        foreach($projects as $project)
        {

Proyek::firstOrCreate(
[
    'nama_proyek'=>$project['nama_proyek']
],
[
    'total_anggaran'=>$project['anggaran']
]);
        }







        /*
        |--------------------------------------------------------------------------
        | 3. DATA KARYAWAN
        |--------------------------------------------------------------------------
        */
$employees = [

[
    'pengguna_id'=>$userIds['TIRA'],
    'nama_karyawan'=>'TIRA',
    'divisi_id'=>4
],

[
    'pengguna_id'=>$userIds['NAYA'],
    'nama_karyawan'=>'NAYA',
    'divisi_id'=>5
],

[
    'pengguna_id'=>$userIds['BELA'],
    'nama_karyawan'=>'BELA',
    'divisi_id'=>6
],

[
    'pengguna_id'=>$userIds['RAUDAH'],
    'nama_karyawan'=>'RAUDAH',
    'divisi_id'=>7
],

[
    'pengguna_id'=>$userIds['SYIFA'],
    'nama_karyawan'=>'SYIFA',
    'divisi_id'=>8
],

[
    'pengguna_id'=>$userIds['YUNICA'],
    'nama_karyawan'=>'YUNICA',
    'divisi_id'=>9
],

[
    'pengguna_id'=>$userIds['YASMIN'],
    'nama_karyawan'=>'YASMIN',
    'divisi_id'=>10
],

[
    'pengguna_id'=>$userIds['MAULIDA'],
    'nama_karyawan'=>'MAULIDA',
    'divisi_id'=>11
],

[
    'pengguna_id'=>$userIds['AUREL'],
    'nama_karyawan'=>'AUREL',
    'divisi_id'=>4
],

[
    'pengguna_id'=>$userIds['ASRIN'],
    'nama_karyawan'=>'ASRIN',
    'divisi_id'=>4
],

];


        foreach($employees as $employee)
        {

            Karyawan::firstOrCreate(
[
    'pengguna_id'=>$employee['pengguna_id']
],
$employee
);


        }








        /*
        |--------------------------------------------------------------------------
        | 4. ALOKASI DIVISI PROYEK
        |--------------------------------------------------------------------------
        */


        $berdikari = Proyek::where(
            'nama_proyek',
            'CV BERDIKARI'
        )->first();

foreach([

    [
        'proyek_id'=>$berdikari->id,
        'divisi_id'=>4,
        'persentase'=>40
    ],

    [
        'proyek_id'=>$berdikari->id,
        'divisi_id'=>5,
        'persentase'=>30
    ],

    [
        'proyek_id'=>$berdikari->id,
        'divisi_id'=>6,
        'persentase'=>30
    ]

] as $alokasi)
{

    AlokasiProyekDivisi::firstOrCreate(
        [
            'proyek_id'=>$alokasi['proyek_id'],
            'divisi_id'=>$alokasi['divisi_id']
        ],
        $alokasi
    );

}


        /*
        |--------------------------------------------------------------------------
        | 5. DATA TUGAS
        |--------------------------------------------------------------------------
        */


        $tira = Karyawan::where(
            'nama_karyawan',
            'TIRA'
        )->first();



        $sunfan = Proyek::where(
            'nama_proyek',
            'CV SUNFAN JAYA PERSADA'
        )->first();



        Tugas::create([

            'proyek_id'=>$sunfan->id,

            'divisi_id'=>4,

            'karyawan_id'=>$tira->id,

            'tanggal'=>Carbon::create(2024,5,12),

            'nama_tugas'=>'UKL UPL 01',

            'aktivitas'=>'Perbaikan administrasi / Kendala: Pertek Air Limbah',

            'prioritas'=>'Low',

            'progres_persen'=>23,

            'status'=>'sedang_dikerjakan'

        ]);





        $berkat = Proyek::where(
            'nama_proyek',
            'PT BERKAT BERSUJUD'
        )->first();



        Tugas::create([

            'proyek_id'=>$berkat->id,

            'divisi_id'=>4,

            'karyawan_id'=>$tira->id,

            'tanggal'=>Carbon::create(2024,6,24),

            'nama_tugas'=>'AMDAL BARU 04',

            'aktivitas'=>'Drafting SK',

            'prioritas'=>'Medium',

            'progres_persen'=>0,

            'status'=>'belum_dikerjakan'

        ]);







        $tiga = Proyek::where(
            'nama_proyek',
            'CV TIGA SERANGKAI BINUANG'
        )->first();



        $aurel = Karyawan::where(
            'nama_karyawan',
            'AUREL'
        )->first();




        Tugas::create([

            'proyek_id'=>$tiga->id,

            'divisi_id'=>4,

            'karyawan_id'=>$aurel->id,

            'tanggal'=>Carbon::create(2025,12,22),

            'nama_tugas'=>'ADDENDUM TIPE A 01',

            'aktivitas'=>'Draft 70% (Kendala data series pemantauan, PKKPR, penapisan amdalnet)',

            'prioritas'=>'Low',

            'progres_persen'=>23,

            'status'=>'sedang_dikerjakan'

        ]);



    }

}