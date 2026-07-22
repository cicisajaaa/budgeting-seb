<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Karyawan;
use App\Models\Divisi;

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





        return view(

            'admin.users.index',

            compact(

                'users'

            )

        );


    }









    /*
    |--------------------------------------------------------------------------
    | FORM TAMBAH USER
    |--------------------------------------------------------------------------
    */


    public function create()
    {


        $divisi = Divisi::all();




        return view(

            'admin.users.create',

            compact(

                'divisi'

            )

        );


    }









    /*
    |--------------------------------------------------------------------------
    | SIMPAN USER
    |--------------------------------------------------------------------------
    */


    public function store(Request $request)
    {


        $request->validate([



            'name'=>'required|string|max:255',



            'email'=>'required|email|unique:users,email',



            'password'=>'required|min:8',



            'role'=>'required|in:owner,admin,bendahara,karyawan',



            'nama_karyawan'=>'nullable|string',



            'divisi_id'=>'nullable|exists:divisi,id'



        ]);








        $user = User::create([



            'name'=>$request->name,



            'email'=>$request->email,



            'password'=>Hash::make(

                $request->password

            ),



            'role'=>$request->role



        ]);









        /*
        |--------------------------------------------------------------------------
        | BUAT DATA KARYAWAN
        |--------------------------------------------------------------------------
        */


        if($request->role == 'karyawan')
        {


            Karyawan::create([



                'pengguna_id'=>$user->id,



                'nama_karyawan'=>$request->nama_karyawan,



                'divisi_id'=>$request->divisi_id



            ]);


        }









        return redirect()

            ->route(

                'admin.users.index'

            )

            ->with(

                'success',

                'User berhasil ditambahkan'

            );


    }









    /*
    |--------------------------------------------------------------------------
    | DETAIL USER
    |--------------------------------------------------------------------------
    */


    public function show(User $user)
    {


        $user->load([

            'karyawan.divisi'

        ]);





        return view(

            'admin.users.show',

            compact(

                'user'

            )

        );


    }









    /*
    |--------------------------------------------------------------------------
    | EDIT USER
    |--------------------------------------------------------------------------
    */


    public function edit(User $user)
    {


        $divisi = Divisi::all();





        $user->load(

            'karyawan'

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
    | UPDATE USER
    |--------------------------------------------------------------------------
    */


    public function update(Request $request, User $user)
    {


        $request->validate([



            'name'=>'required|string|max:255',



            'email'=>'required|email|unique:users,email,'.$user->id,



            'role'=>'required|in:owner,admin,bendahara,karyawan',



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









        if($request->role == 'karyawan')
        {


            Karyawan::updateOrCreate(



                [

                    'pengguna_id'=>$user->id

                ],



                [


                    'nama_karyawan'=>

                        $request->nama_karyawan,



                    'divisi_id'=>

                        $request->divisi_id


                ]



            );


        }









        return redirect()

            ->route(

                'admin.users.index'

            )

            ->with(

                'success',

                'User berhasil diperbarui'

            );


    }









    /*
    |--------------------------------------------------------------------------
    | HAPUS USER
    |--------------------------------------------------------------------------
    */


    public function destroy(User $user)
    {


        $user->delete();




        return redirect()

            ->route(

                'admin.users.index'

            )

            ->with(

                'success',

                'User berhasil dihapus'

            );


    }



}