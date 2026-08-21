<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Divisi;
use Illuminate\Http\Request;

use App\Helpers\AuditHelper;

class DivisionController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | LIST DIVISI
    |--------------------------------------------------------------------------
    */

    public function index()
    {

        $divisions = Divisi::with([
            'karyawan'
        ])

        ->latest()

        ->get();



        return view(
            'admin.divisions.index',
            compact('divisions')
        );

    }









    /*
    |--------------------------------------------------------------------------
    | FORM TAMBAH DIVISI
    |--------------------------------------------------------------------------
    */

    public function create()
    {

        return view(
            'admin.divisions.create'
        );

    }









    /*
    |--------------------------------------------------------------------------
    | SIMPAN DIVISI
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {

        $request->validate([

            'nama_divisi'
                =>'required|string|max:255',

            'deskripsi'
                =>'nullable|string'

        ]);




        $division = Divisi::create([

            'nama_divisi'=>$request->nama_divisi,

            'deskripsi'=>$request->deskripsi

        ]);


        AuditHelper::create(

            'Tambah Divisi',

            'Manajemen Divisi',

            'Admin menambahkan divisi '.$division->nama_divisi

        );


        return redirect()

            ->route(
                'admin.divisions.index'
            )

            ->with(
                'success',
                'Divisi berhasil ditambahkan'
            );

    }









    /*
    |--------------------------------------------------------------------------
    | DETAIL DIVISI
    |--------------------------------------------------------------------------
    */

    public function show(Divisi $division)
    {


        $division->load([

            'karyawan',

            'alokasiProyekDivisi'

        ]);




        return view(
            'admin.divisions.show',
            compact('division')
        );


    }









    /*
    |--------------------------------------------------------------------------
    | EDIT DIVISI
    |--------------------------------------------------------------------------
    */

    public function edit(Divisi $division)
    {

        return view(
            'admin.divisions.edit',
            compact('division')
        );

    }









    /*
    |--------------------------------------------------------------------------
    | UPDATE DIVISI
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, Divisi $division)
    {


        $request->validate([

            'nama_divisi'
                =>'required|string|max:255',

            'deskripsi'
                =>'nullable|string'

        ]);






        $division->update([

            'nama_divisi'
                =>$request->nama_divisi,

            'deskripsi'
                =>$request->deskripsi

        ]);


        AuditHelper::create(

            'Update Divisi',

            'Manajemen Divisi',

            'Admin memperbarui divisi '.$division->nama_divisi

        );



        return redirect()

            ->route(
                'admin.divisions.index'
            )

            ->with(
                'success',
                'Divisi berhasil diperbarui'
            );


    }









    /*
    |--------------------------------------------------------------------------
    | HAPUS DIVISI
    |--------------------------------------------------------------------------
    */
public function destroy(Divisi $division)
{


    if(
    $division->karyawan()->count() > 0 ||
    $division->alokasiProyekDivisi()->count() > 0
)
    {

        return back()->withErrors([

            'division'=>'Divisi tidak dapat dihapus karena masih digunakan oleh karyawan atau project.'

        ]);

    }


    AuditHelper::create(

        'Hapus Divisi',

        'Manajemen Divisi',

        'Admin menghapus divisi '.$division->nama_divisi

    );



    $division->delete();



    return redirect()

        ->route('admin.divisions.index')

        ->with(

            'success',

            'Divisi berhasil dihapus'

        );


}


}