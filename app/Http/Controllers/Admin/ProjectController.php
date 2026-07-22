<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

use App\Models\Proyek;

use Illuminate\Http\Request;



class ProjectController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | LIST PROJECT
    |--------------------------------------------------------------------------
    */


    public function index()
    {


        $projects = Proyek::latest()

            ->get();





        return view(

            'admin.projects.index',

            compact(

                'projects'

            )

        );


    }









    /*
    |--------------------------------------------------------------------------
    | FORM TAMBAH PROJECT
    |--------------------------------------------------------------------------
    */


    public function create()
    {


        return view(

            'admin.projects.create'

        );


    }









    /*
    |--------------------------------------------------------------------------
    | SIMPAN PROJECT
    |--------------------------------------------------------------------------
    */


    public function store(Request $request)
    {


        $request->validate([



            'nama_proyek'=>'required|string|max:255',



            'tanggal_mulai'=>'required|date',



            'tanggal_selesai'=>'nullable|date',



            'pemilik_proyek'=>'nullable|string|max:255',



            'total_anggaran'=>'required|numeric|min:0',



        ]);









        Proyek::create([



            'nama_proyek'=>

                $request->nama_proyek,



            'tanggal_mulai'=>

                $request->tanggal_mulai,



            'tanggal_selesai'=>

                $request->tanggal_selesai,



            'pemilik_proyek'=>

                $request->pemilik_proyek,



            'total_anggaran'=>

                $request->total_anggaran,



        ]);









        return redirect()

            ->route(

                'admin.projects.index'

            )

            ->with(

                'success',

                'Project berhasil ditambahkan'

            );


    }









    /*
    |--------------------------------------------------------------------------
    | DETAIL PROJECT
    |--------------------------------------------------------------------------
    */


    public function show(Proyek $project)
    {


        $project->load([

            'tugas',

            'alokasiDivisi'

        ]);





        return view(

            'admin.projects.show',

            compact(

                'project'

            )

        );


    }









    /*
    |--------------------------------------------------------------------------
    | FORM EDIT PROJECT
    |--------------------------------------------------------------------------
    */


    public function edit(Proyek $project)
    {


        return view(

            'admin.projects.edit',

            compact(

                'project'

            )

        );


    }









    /*
    |--------------------------------------------------------------------------
    | UPDATE PROJECT
    |--------------------------------------------------------------------------
    */


    public function update(Request $request, Proyek $project)
    {


        $request->validate([



            'nama_proyek'=>'required|string|max:255',



            'tanggal_mulai'=>'required|date',



            'tanggal_selesai'=>'nullable|date',



            'pemilik_proyek'=>'nullable|string|max:255',



            'total_anggaran'=>'required|numeric|min:0',



        ]);









        $project->update([



            'nama_proyek'=>

                $request->nama_proyek,



            'tanggal_mulai'=>

                $request->tanggal_mulai,



            'tanggal_selesai'=>

                $request->tanggal_selesai,



            'pemilik_proyek'=>

                $request->pemilik_proyek,



            'total_anggaran'=>

                $request->total_anggaran,



        ]);









        return redirect()

            ->route(

                'admin.projects.index'

            )

            ->with(

                'success',

                'Project berhasil diperbarui'

            );


    }









    /*
    |--------------------------------------------------------------------------
    | DELETE PROJECT
    |--------------------------------------------------------------------------
    */


    public function destroy(Proyek $project)
    {


        $project->delete();




        return redirect()

            ->route(

                'admin.projects.index'

            )

            ->with(

                'success',

                'Project berhasil dihapus'

            );


    }



}