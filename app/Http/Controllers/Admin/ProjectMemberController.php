<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Proyek;
use App\Models\User;



class ProjectMemberController extends Controller
{


    public function index(Proyek $project)
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
        Proyek $project
    )
    {


$request->validate([
    'user_id' => [
        'required',
        'exists:users,id',
        'integer'
    ]
]);

$user = User::where('id', $request->user_id)
    ->where('role', 'karyawan')
    ->firstOrFail();



 $project
    ->users()
    ->syncWithoutDetaching([
        $user->id
    ]);



        return back()->with(
            'success',
            'Karyawan berhasil ditambahkan ke project'
        );


    }







    public function destroy(
        Proyek $project,
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