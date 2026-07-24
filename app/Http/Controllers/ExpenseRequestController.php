<?php

namespace App\Http\Controllers;


use App\Models\Proyek;
use App\Models\Divisi;
use App\Models\PengajuanDana;
use App\Models\User;

use App\Notifications\NewExpenseRequest;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class ExpenseRequestController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | FORM PENGAJUAN DANA
    |--------------------------------------------------------------------------
    */


    public function create()
    {


        $projects = Proyek::all();


        $divisions = Divisi::all();




        return view(

            'expense.create',

            compact(

                'projects',

                'divisions'

            )

        );


    }









    /*
    |--------------------------------------------------------------------------
    | SIMPAN PENGAJUAN DANA
    |--------------------------------------------------------------------------
    */


    public function store(Request $request)
    {


        $request->validate([



            'proyek_id'=>'required|exists:proyek,id',



            'divisi_id'=>'required|exists:divisi,id',



            'judul'=>'required|string|max:255',



            'jumlah'=>'required|numeric|min:1',



            'keterangan'=>'nullable|string',



        ]);








        /*
        |--------------------------------------------------------------------------
        | SIMPAN PENGAJUAN
        |--------------------------------------------------------------------------
        */


        $expense = PengajuanDana::create([



            'proyek_id'=>$request->proyek_id,



            'divisi_id'=>$request->divisi_id,



            'pengguna_id'=>Auth::id(),



            'judul'=>$request->judul,



            'keterangan'=>$request->keterangan,



            'jumlah'=>$request->jumlah,



            'status'=>'pending',



        ]);









        /*
        |--------------------------------------------------------------------------
        | NOTIFIKASI KEUANGAN
        |--------------------------------------------------------------------------
        */


        $keuangan = User::where(

            'role',

            'keuangan'

        )

        ->get();








        foreach($keuangan as $user)
        {


            $user->notify(

                new NewExpenseRequest($expense)

            );


        }









        return back()

        ->with(

            'success',

            'Pengajuan dana berhasil dikirim dan menunggu persetujuan keuangan'

        );


    }









    /*
    |--------------------------------------------------------------------------
    | HISTORY PENGAJUAN KARYAWAN
    |--------------------------------------------------------------------------
    */


    public function history()
    {


        $requests = PengajuanDana::with([


            'proyek',


            'divisi',


            'penyetuju'


        ])

        ->where(

            'pengguna_id',

            Auth::id()

        )

        ->latest()

        ->get();








        return view(

            'expense.history',

            compact(

                'requests'

            )

        );


    }



}