<?php

namespace App\Http\Controllers\Owner;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ExpenseRequest;

class OwnerApprovalController extends Controller
{

public function index()

    {

        $requests = ExpenseRequest::with([

            'user',

            'proyek'

        ])

        ->where('status','pending')

        ->latest()

        ->get();

        return view(

            'owner.approval.index',

            compact('requests')

        );

    }

    public function detail($id)
{

    $expense = ExpenseRequest::with([
        'user',
        'proyek',
        'division'
    ])
    ->findOrFail($id);



    return view(
        'owner.approval.detail',
        compact('expense')
    );

}

public function approve($id)
{

    $expense = ExpenseRequest::findOrFail($id);


    $expense->update([

        'status'=>'approved',

        'disetujui_oleh'=>auth()->id(),

        'disetujui_pada'=>now()

    ]);



    return redirect()
    ->route('owner.approval')
    ->with(
        'success',
        'Pengajuan dana berhasil disetujui'
    );

}





public function reject(Request $request,$id)
{

    $expense = ExpenseRequest::findOrFail($id);



    $expense->update([

        'status'=>'rejected',

        'disetujui_oleh'=>auth()->id(),

        'disetujui_pada'=>now(),

        'catatan_persetujuan'=>$request->catatan

    ]);



    return redirect()
    ->route('owner.approval')
    ->with(
        'success',
        'Pengajuan dana ditolak'
    );

}

}