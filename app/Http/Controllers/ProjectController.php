<?php

namespace App\Http\Controllers;

use App\Models\Proyek;

class ProjectController extends Controller
{
    public function myProject()
    {

        $karyawan = auth()->user()->karyawan;


        if (!$karyawan) {

            abort(
                403,
                'Akun belum terhubung dengan data karyawan.'
            );

        }


        $proyek = Proyek::whereHas(
            'tugas',
            function($query) use ($karyawan){

                $query->where(
                    'karyawan_id',
                    $karyawan->id
                );

            }
        )
        ->with([

            // ambil perusahaan proyek
            'perusahaan',

            // tugas karyawan
            'tugas' => function($query) use ($karyawan){

                $query->where(
                    'karyawan_id',
                    $karyawan->id
                )
                ->orderBy('id');

            },

            // aktivitas tugas
            'tugas.aktivitasTugas'

        ])
        ->latest()
        ->get();



        return view(
            'project.my-project',
            compact('proyek')
        );

    }
}