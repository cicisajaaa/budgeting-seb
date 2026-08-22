<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Perusahaan;
use Illuminate\Http\Request;

class PerusahaanController extends Controller
{
public function index()
{
    $perusahaans = Perusahaan::with('proyek')
        ->latest()
        ->get();


    return view(
        'admin.perusahaan.index',
        compact('perusahaans')
    );
}


    public function create()
    {
        return view(
            'admin.perusahaan.create'
        );
    }


    public function store(Request $request)
    {

        $request->validate([

            'nama_perusahaan'=>'required',
            'email'=>'nullable|email',
            'status'=>'required'

        ]);


        Perusahaan::create([

            'nama_perusahaan'=>$request->nama_perusahaan,
            'alamat'=>$request->alamat,
            'kontak'=>$request->kontak,
            'email'=>$request->email,
            'status'=>$request->status,

        ]);


        return redirect()
            ->route('admin.perusahaan.index')
            ->with(
                'success',
                'Perusahaan berhasil ditambahkan'
            );

    }



    public function show(Perusahaan $perusahaan)
    {

        $perusahaan->load('proyek');

        return view(
            'admin.perusahaan.show',
            compact('perusahaan')
        );

    }



    public function edit(Perusahaan $perusahaan)
    {

        return view(
            'admin.perusahaan.edit',
            compact('perusahaan')
        );

    }



    public function update(Request $request, Perusahaan $perusahaan)
    {

        $request->validate([

            'nama_perusahaan'=>'required',
            'email'=>'nullable|email',
            'status'=>'required'

        ]);


        $perusahaan->update([

            'nama_perusahaan'=>$request->nama_perusahaan,
            'alamat'=>$request->alamat,
            'kontak'=>$request->kontak,
            'email'=>$request->email,
            'status'=>$request->status,

        ]);


        return redirect()
            ->route('admin.perusahaan.index')
            ->with(
                'success',
                'Perusahaan berhasil diperbarui'
            );

    }



    public function destroy(Perusahaan $perusahaan)
    {

        $perusahaan->delete();


        return redirect()
            ->route('admin.perusahaan.index')
            ->with(
                'success',
                'Perusahaan berhasil dihapus'
            );

    }

}