<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

use App\Models\Proyek;
use App\Models\Divisi;
use App\Models\AlokasiProyekDivisi;

use Illuminate\Http\Request;



class AllocationController extends Controller
{


    public function index($project)
    {


        $project = Proyek::findOrFail($project);



        $allocations = AlokasiProyekDivisi::with([

            'divisi'

        ])

        ->where(

            'proyek_id',

            $project->id

        )

        ->latest()

        ->get();





        $divisions = Divisi::latest()->get();





        return view(

            'admin.allocation.index',

            compact(

                'project',

                'allocations',

                'divisions'

            )

        );


    }








    public function store(Request $request,$project)
    {


        $project = Proyek::findOrFail($project);





        $request->validate([


            'divisi_id'=>

            [

                'required',

                'exists:divisi,id',

            ],




            'persentase'=>

            [

                'required',

                'numeric',

                'min:1',

                'max:100'

            ]


        ]);








        $cekDivisi = AlokasiProyekDivisi::where([


            'proyek_id'=>$project->id,


            'divisi_id'=>$request->divisi_id


        ])

        ->exists();





        if($cekDivisi)
        {


            return back()

            ->with(

                'error',

                'Divisi tersebut sudah memiliki alokasi dana'

            );


        }









        $total = AlokasiProyekDivisi::where(

            'proyek_id',

            $project->id

        )

        ->sum('persentase');








        if(

            $total + $request->persentase > 100

        )
        {


            return back()

            ->with(

                'error',

                'Total pembagian dana melebihi 100%'

            );


        }








        AlokasiProyekDivisi::create([


            'proyek_id'=>$project->id,


            'divisi_id'=>$request->divisi_id,


            'persentase'=>$request->persentase,


        ]);








        return back()

        ->with(

            'success',

            'Pembagian dana berhasil ditambahkan'

        );


    }








    public function destroy($allocation)
    {


        $allocation = AlokasiProyekDivisi::findOrFail($allocation);



        $allocation->delete();





        return back()

        ->with(

            'success',

            'Alokasi berhasil dihapus'

        );


    }



}