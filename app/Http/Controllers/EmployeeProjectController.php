<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use Illuminate\Support\Facades\Auth;


class EmployeeProjectController extends Controller
{

    public function index()
    {


    $user = Auth::user();

    if(!$user)

    {

        abort(401);

    }

    $karyawan = $user->karyawan;

    if(!$karyawan)

    {

        abort(403);

    }


        $proyek = Proyek::whereHas(
            'tugas',
            function ($query) use ($karyawan) {

                $query->where(
                    'karyawan_id',
                    $karyawan->id
                );

            }
        )


        ->with([

            'perusahaan:id,nama_perusahaan,alamat,kontak',

            'perusahaan.proyek:id,perusahaan_id,nama_proyek',

            'users:id,name',


            'tugas' => function ($query) use ($karyawan) {


                $query->where(
                    'karyawan_id',
                    $karyawan->id
                )


                /*
                ==================================
                URUTAN TASK
                1. Belum dikerjakan
                2. Sedang dikerjakan
                3. Selesai
                ==================================
                */


                ->orderByRaw("
CASE

    WHEN status NOT IN ('selesai','done')
    AND deadline < CURDATE()
    THEN 1


    WHEN status IN (
        'sedang_dikerjakan',
        'berjalan',
        'progress'
    )
    THEN 2


    WHEN status = 'belum_dikerjakan'
    THEN 3


    WHEN status IN (
        'selesai',
        'done'
    )
    THEN 4


    ELSE 5

END
")



                /*
                Deadline kosong taruh terakhir
                */

                ->orderByRaw("
                CASE

                    WHEN deadline IS NULL
                    THEN 1

                    ELSE 0

                END
                ")



                /*
                Deadline terdekat dulu
                */

                ->orderBy(
                    'deadline',
                    'asc'
                )



                ->with([

                'aktivitasTugas' => function($q){

                    $q->latest();

                },


                    'divisi',


                    'karyawan'


                ]);

            }

        ])


        ->latest()


        ->get();



        return view(

            'employee.projects.index',

            compact(
                'proyek'
            )

        );


    }

}