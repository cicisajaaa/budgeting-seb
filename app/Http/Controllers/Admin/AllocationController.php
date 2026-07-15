<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

use App\Models\Project;
use App\Models\Division;
use App\Models\ProjectDivisionAllocation;

use Illuminate\Http\Request;



class AllocationController extends Controller
{


    public function index(Project $project)
    {


        $divisions = Division::all();


        $allocations = ProjectDivisionAllocation::where(
            'project_id',
            $project->id
        )
        ->get();



        return view(
            'admin.allocations.index',
            compact(
                'project',
                'divisions',
                'allocations'
            )
        );


    }






    public function store(
        Request $request,
        Project $project
    )
    {



        $request->validate([

            'division_id'=>'required',

            'persentase'=>'required|numeric|min:1|max:100'

        ]);




$total = ProjectDivisionAllocation::where(
    'project_id',
    $project->id
)
->sum('persentase');


$newTotal = $total + $request->persentase;



        if($newTotal > 100)
        {

            return back()
                ->with(
                    'error',
                    'Total pembagian dana tidak boleh lebih dari 100%'
                );

        }




        if(
            $total + $request->persentase > 100
        )
        {

            return back()
            ->with(
                'error',
                'Total persentase tidak boleh lebih dari 100%'
            );

        }




        ProjectDivisionAllocation::create([

            'project_id'=>$project->id,

            'division_id'=>$request->division_id,

            'persentase'=>$request->persentase,

        ]);




        return back()
        ->with(
            'success',
            'Pembagian dana berhasil ditambahkan'
        );



    }






    public function destroy(
        ProjectDivisionAllocation $allocation
    )
    {


        $allocation->delete();



        return back();



    }


}