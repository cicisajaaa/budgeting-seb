<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\Request;



class DivisionController extends Controller
{


    public function index()
    {


        $divisions = Division::latest()->get();


        return view(
            'admin.divisions.index',
            compact('divisions')
        );


    }





    public function create()
    {


        return view(
            'admin.divisions.create'
        );


    }





    public function store(Request $request)
    {


        $request->validate([

            'nama_divisi'=>'required'

        ]);



        Division::create([

            'nama_divisi'=>$request->nama_divisi

        ]);



        return redirect()

            ->route('admin.divisions.index')

            ->with(
                'success',
                'Divisi berhasil ditambahkan'
            );


    }






    public function edit(Division $division)
    {


        return view(
            'admin.divisions.edit',
            compact('division')
        );


    }






    public function update(
        Request $request,
        Division $division
    )
    {


        $request->validate([

            'nama_divisi'=>'required'

        ]);



        $division->update([

            'nama_divisi'=>$request->nama_divisi

        ]);



        return redirect()

            ->route('admin.divisions.index')

            ->with(
                'success',
                'Divisi berhasil diperbarui'
            );


    }






    public function destroy(Division $division)
    {


        $division->delete();



        return back()

            ->with(
                'success',
                'Divisi berhasil dihapus'
            );


    }


}