<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class EmployeeProjectController extends Controller
{

    public function index(Request $request)
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



        $search = trim(
            $request->get('search','')
        );



        $proyek = Proyek::whereHas(

            'tugas',

            function($query) use ($karyawan){

                $query->where(
                    'karyawan_id',
                    $karyawan->id
                );

            }

        )

        ->when($search !== '', function($query) use ($search){

            $query->where(
                'nama_proyek',
                'like',
                '%'.$search.'%'
            );

        })



        ->with([


            'perusahaan:id,nama_perusahaan,alamat,kontak',


            'perusahaan.proyek:id,perusahaan_id,nama_proyek',


            'users:id,name',



            'tugas'=>function($query) use ($karyawan){


                $query->where(
                    'karyawan_id',
                    $karyawan->id
                )


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


                    WHEN status='belum_dikerjakan'
                    THEN 3


                    WHEN status IN (
                        'selesai',
                        'done'
                    )
                    THEN 4


                    ELSE 5

                END

                ")



                ->orderByRaw("

                CASE

                    WHEN deadline IS NULL
                    THEN 1
                    ELSE 0

                END

                ")


                ->orderBy(
                    'deadline',
                    'asc'
                )



                ->with([

                    'aktivitasTugas'=>function($q){

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

                'proyek',

                'search'

            )

        );


    }

}