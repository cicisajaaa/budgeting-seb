<?php

namespace App\Http\Controllers;


use App\Models\Project;
use App\Models\Division;
use App\Models\ExpenseRequest;
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


        $projects = Project::all();


        $divisions = Division::all();




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


            'project_id'=>'required|exists:projects,id',


            'division_id'=>'required|exists:divisions,id',


            'judul'=>'required|string|max:255',


            'jumlah'=>'required|numeric|min:1',


            'keterangan'=>'nullable|string',



        ]);









        /*
        |--------------------------------------------------------------------------
        | SIMPAN REQUEST
        |--------------------------------------------------------------------------
        */


        $expense = ExpenseRequest::create([



            'project_id'=>$request->project_id,



            'division_id'=>$request->division_id,



            'user_id'=>Auth::id(),



            'judul'=>$request->judul,



            'keterangan'=>$request->keterangan,



            'jumlah'=>$request->jumlah,



            'status'=>'pending',



        ]);









        /*
        |--------------------------------------------------------------------------
        | KIRIM NOTIFIKASI BENDAHARA
        |--------------------------------------------------------------------------
        */


        $bendahara = User::where(

            'role',

            'bendahara'

        )
        ->get();








        foreach($bendahara as $user)
        {


            $user->notify(

                new NewExpenseRequest($expense)

            );


        }









        return back()

        ->with(

            'success',

            'Pengajuan dana berhasil dikirim dan menunggu persetujuan bendahara'

        );


    }









    /*
    |--------------------------------------------------------------------------
    | HISTORY PENGAJUAN KARYAWAN
    |--------------------------------------------------------------------------
    */


    public function history()
    {


        $requests = ExpenseRequest::with([


            'project',


            'division',


            'approver'


        ])

        ->where(

            'user_id',

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