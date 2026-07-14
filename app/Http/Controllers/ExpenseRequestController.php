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





    public function store(Request $request)
    {


        $request->validate([

            'project_id' => 'required',

            'division_id' => 'required',

            'judul' => 'required',

            'jumlah' => 'required|numeric',

        ]);




        /*
        |--------------------------------------------------------------------------
        | Simpan Pengajuan Dana
        |--------------------------------------------------------------------------
        */


        $expense = ExpenseRequest::create([

            'project_id' => $request->project_id,

            'division_id' => $request->division_id,

            'user_id' => Auth::id(),

            'judul' => $request->judul,

            'keterangan' => $request->keterangan,

            'jumlah' => $request->jumlah,

            'status' => 'pending',

        ]);






        /*
        |--------------------------------------------------------------------------
        | Kirim Notifikasi ke Bendahara
        |--------------------------------------------------------------------------
        */


        $bendahara = User::where(
            'role',
            'bendahara'
        )
        ->first();



        if($bendahara)
        {

            $bendahara->notify(
                new NewExpenseRequest($expense)
            );

        }





        return back()
            ->with(
                'success',
                'Pengajuan berhasil dikirim dan menunggu persetujuan bendahara'
            );


    }





    public function history()
    {

        $requests = ExpenseRequest::with([
            'project',
            'division'
        ])
        ->where(
            'user_id',
            Auth::id()
        )
        ->latest()
        ->get();



        return view(
            'expense.history',
            compact('requests')
        );

    }


}