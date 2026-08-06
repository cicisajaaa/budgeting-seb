<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Karyawan;
use App\Models\Divisi;
use App\Models\LogAudit;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | LIST USER
    |--------------------------------------------------------------------------
    */

    public function index()
    {


        $users = User::with([
            'karyawan.divisi'
        ])
        ->latest()
        ->get();




        $totalUser = User::count();



        $totalAdmin = User::where(
            'role',
            'admin'
        )->count();




        $totalKaryawan = User::whereIn(
            'role',
            [
                'admin',
                'keuangan',
                'karyawan'
            ]
        )->count();




        $totalProject = \App\Models\Proyek::count();


        $totalTask = \App\Models\Tugas::count();


        $totalDivision = Divisi::count();




        $totalExpenseRequest = \App\Models\PengajuanDana::count();



        $totalPendingExpense = \App\Models\PengajuanDana::where(
            'status',
            'pending'
        )->count();



        $totalApprovedExpense = \App\Models\PengajuanDana::where(
            'status',
            'disetujui'
        )->count();



        $totalRejectedExpense = \App\Models\PengajuanDana::where(
            'status',
            'ditolak'
        )->count();





        $recentProjects = \App\Models\Proyek::latest()
            ->limit(5)
            ->get();





        $recentAudit = LogAudit::with(
            'pengguna'
        )
        ->latest()
        ->limit(5)
        ->get();






        return view(

            'admin.users.index',

            compact(

                'users',

                'totalUser',

                'totalAdmin',

                'totalKaryawan',

                'totalProject',

                'totalTask',

                'totalDivision',

                'totalExpenseRequest',

                'totalPendingExpense',

                'totalApprovedExpense',

                'totalRejectedExpense',

                'recentProjects',

                'recentAudit'

            )

        );


    }








    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {


        $divisi = Divisi::all();



        return view(

            'admin.users.create',

            compact('divisi')

        );


    }









    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {


        $request->validate([


            'name'=>'required|string|max:255',


            'email'=>'required|email|unique:users,email',


            'password'=>'required|min:8',


            'role'=>'required|in:owner,admin,keuangan,karyawan',


            'nama_karyawan'=>'required_if:role,admin,keuangan,karyawan|string',


            'divisi_id'=>'required_if:role,admin,keuangan,karyawan|exists:divisi,id'


        ]);





        $user = User::create([


            'name'=>$request->name,


            'email'=>$request->email,


            'password'=>Hash::make(
                $request->password
            ),


            'role'=>$request->role


        ]);






        // Admin, Keuangan, Karyawan memiliki data karyawan

        if(in_array($request->role,[
            'admin',
            'keuangan',
            'karyawan'
        ]))
        {


            Karyawan::create([


                'pengguna_id'=>$user->id,


                'nama_karyawan'=>$request->nama_karyawan
                    ?? $request->name,


                'divisi_id'=>$request->divisi_id


            ]);


        }







        return redirect()

            ->route('admin.users.index')

            ->with(

                'success',

                'User berhasil ditambahkan'

            );


    }









    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */


    public function show(User $user)
    {


        $user->load([

            'karyawan.divisi',

            'karyawan.tugas',

            'logAudit',

            'pengajuanDana'

        ]);





        $totalTask = 0;


        $taskSelesai = 0;





        if($user->karyawan)
        {


            $totalTask = $user
                ->karyawan
                ->tugas
                ->count();



            $taskSelesai = $user
                ->karyawan
                ->tugas
                ->where(
                    'status',
                    'selesai'
                )
                ->count();


        }





        $totalPengajuan = $user
            ->pengajuanDana
            ->count();






        return view(

            'admin.users.show',

            compact(

                'user',

                'totalTask',

                'taskSelesai',

                'totalPengajuan'

            )

        );


    }









    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(User $user)
    {


        $divisi = Divisi::all();



        $user->load(
            'karyawan.divisi'
        );





        return view(

            'admin.users.edit',

            compact(

                'user',

                'divisi'

            )

        );


    }









    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
public function update(Request $request, User $user)
{

    $request->validate([

        'name'=>'required|string|max:255',

        'email'=>'required|email|unique:users,email,'.$user->id,

        'role'=>'required|in:owner,admin,keuangan,karyawan'

    ]);





    $user->update([

        'name'=>$request->name,

        'email'=>$request->email,

        'role'=>$request->role

    ]);






    if($request->password)
    {

        $user->update([

            'password'=>Hash::make(
                $request->password
            )

        ]);

    }







    /*
    |--------------------------------------------------------------------------
    | KELOLA DATA KARYAWAN
    |--------------------------------------------------------------------------
    */


    if(in_array($request->role,[

        'admin',

        'keuangan',

        'karyawan'

    ]))

    {


        $request->validate([


            'nama_karyawan'=>'required|string',


            'divisi_id'=>'required|exists:divisi,id'


        ]);





        Karyawan::updateOrCreate(

            [

                'pengguna_id'=>$user->id

            ],


            [

                'nama_karyawan'=>$request->nama_karyawan,

                'divisi_id'=>$request->divisi_id

            ]

        );


    }

    else

    {


        Karyawan::where(

            'pengguna_id',

            $user->id

        )->delete();


    }







    return redirect()

        ->route('admin.users.index')

        ->with(

            'success',

            'User berhasil diperbarui'

        );


}





    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy(User $user)
    {


        $user->delete();



        return redirect()

            ->route('admin.users.index')

            ->with(

                'success',

                'User berhasil dihapus'

            );


    }


}