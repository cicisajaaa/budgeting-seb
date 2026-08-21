<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

use App\Models\Proyek;
use App\Models\Perusahaan;

use Illuminate\Http\Request;

use App\Helpers\AuditHelper;

class ProjectController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | LIST PROJECT
    |--------------------------------------------------------------------------
    */


    public function index()
    {


        $projects = Proyek::with('perusahaan')
            ->latest()
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
            $perusahaans = Perusahaan::where(
                'status',
                'aktif'
            )->get();


            return view(
                'admin.projects.create',
                compact('perusahaans')
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

            'perusahaan_id'=>'required|exists:perusahaans,id',


            'nama_proyek'=>'required|string|max:255',


            'tanggal_mulai'=>'required|date',



            'tanggal_selesai'=>'nullable|date',



            'pemilik_proyek'=>'nullable|string|max:255',



            'total_anggaran'=>'required|numeric|min:0',



        ]);








        $project = Proyek::create([

            'perusahaan_id'=>$request->perusahaan_id,

            'nama_proyek'=>$request->nama_proyek,

            'tanggal_mulai'=>$request->tanggal_mulai,

            'tanggal_selesai'=>$request->tanggal_selesai,

            'pemilik_proyek'=>$request->pemilik_proyek,

            'total_anggaran'=>$request->total_anggaran,


        ]);





        AuditHelper::create(

            'Tambah Project',

            'Manajemen Project',

            'Admin menambahkan project '.$project->nama_proyek

        );


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

            'perusahaan',

            'tugas',

            'alokasiDivisi',

            'users'

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


        $perusahaans = Perusahaan::where(
            'status',
            'aktif'
        )->get();


        return view(
            'admin.projects.edit',
            compact(
                'project',
                'perusahaans'
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

            'perusahaan_id'=>'required|exists:perusahaans,id',


            'nama_proyek'=>'required|string|max:255',



            'tanggal_mulai'=>'required|date',



            'tanggal_selesai'=>'nullable|date',



            'pemilik_proyek'=>'nullable|string|max:255',



            'total_anggaran'=>'required|numeric|min:0',



        ]);









        $project->update([


            'perusahaan_id'=>
            
            $request->perusahaan_id,


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



        AuditHelper::create(

            'Update Project',

            'Manajemen Project',

            'Admin memperbarui project '.$project->nama_proyek

        );





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


    if(

        $project->tugas()->count() > 0 ||

        $project->alokasiDivisi()->count() > 0 ||

        $project->users()->count() > 0 ||

        $project->setoranProyek()->count() > 0

    ){

        return back()->withErrors([

            'project'=>'Project tidak dapat dihapus karena masih memiliki tugas, anggota, alokasi, atau transaksi.'

        ]);

    }





    AuditHelper::create(

        'Hapus Project',

        'Manajemen Project',

        'Admin menghapus project '.$project->nama_proyek

    );





    $project->delete();





    return redirect()

        ->route('admin.projects.index')

        ->with(

            'success',

            'Project berhasil dihapus'

        );


}

}