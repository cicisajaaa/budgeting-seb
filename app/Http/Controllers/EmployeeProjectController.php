<?php

namespace App\Http\Controllers;


use App\Models\Proyek;

use Illuminate\Support\Facades\Auth;



class EmployeeProjectController extends Controller
{


    public function index()
    {


        $karyawan = Auth::user()->karyawan;




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



            'tugas' => function ($query) use ($karyawan) {


                $query

                ->where(

                    'karyawan_id',

                    $karyawan->id

                )

                ->with([

                    'aktivitasTugas'

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