<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

use App\Models\Proyek;
use App\Models\Divisi;
use App\Models\AlokasiProyekDivisi;

use Illuminate\Http\Request;



class AllocationController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | HALAMAN ALOKASI DANA DIVISI
    |--------------------------------------------------------------------------
    */


    public function index(Proyek $project)
{


    $allocations = AlokasiProyekDivisi::with([

        'divisi'

    ])

    ->where(

        'proyek_id',

        $project->id

    )

    ->get();




    $divisions = Divisi::all();




    return view(

        'admin.allocation.index',

        compact(

            'project',

            'allocations',

            'divisions'

        )

    );


}




    /*
    |--------------------------------------------------------------------------
    | SIMPAN ALOKASI
    |--------------------------------------------------------------------------
    */


    public function store(Request $request, Proyek $project)
    {


        $request->validate([



            'divisi_id'=>

                'required|exists:divisi,id',




            'persentase'=>

                'required|numeric|min:0|max:100',



        ]);









        $totalPersentase = AlokasiProyekDivisi::where(

            'proyek_id',

            $project->id

        )

        ->sum(

            'persentase'

        );








        if(

            ($totalPersentase + $request->persentase)

            >

            100

        )
        {


            return back()

            ->with(

                'error',

                'Total alokasi tidak boleh lebih dari 100%'

            );


        }









        AlokasiProyekDivisi::create([



            'proyek_id'=>

                $project->id,



            'divisi_id'=>

                $request->divisi_id,



            'persentase'=>

                $request->persentase



        ]);









        return back()

            ->with(

                'success',

                'Alokasi divisi berhasil ditambahkan'

            );


    }









    /*
    |--------------------------------------------------------------------------
    | HAPUS ALOKASI
    |--------------------------------------------------------------------------
    */


    public function destroy(AlokasiProyekDivisi $allocation)
    {


        $allocation->delete();




        return back()

            ->with(

                'success',

                'Alokasi berhasil dihapus'

            );


    }



}