<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Project;
use App\Models\User;



class ProjectMemberController extends Controller
{


    public function index(Project $project)
    {


        $employees = User::where(
            'role',
            'karyawan'
        )
        ->get();



        $members = $project
            ->users()
            ->get();



        return view(
            'admin.projects.members',
            compact(
                'project',
                'employees',
                'members'
            )
        );


    }







    public function store(
        Request $request,
        Project $project
    )
    {


        $request->validate([

            'user_id'=>'required'

        ]);



        $project
            ->users()
            ->syncWithoutDetaching([
                $request->user_id
            ]);



        return back()->with(
            'success',
            'Karyawan berhasil ditambahkan ke project'
        );


    }







    public function destroy(
        Project $project,
        User $user
    )
    {


        $project
            ->users()
            ->detach($user->id);



        return back()->with(
            'success',
            'Karyawan berhasil dikeluarkan dari project'
        );


    }


}