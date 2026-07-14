<?php

namespace App\Http\Controllers;

use App\Models\ExpenseRequest;
use App\Models\ExpenseTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\DivisionBalance;

class ExpenseApprovalController extends Controller
{


    public function index()
    {

        $requests = ExpenseRequest::with([
            'project',
            'division',
            'user'
        ])
        ->where('status','pending')
        ->latest()
        ->get();


        return view(
            'expense.approval.index',
            compact('requests')
        );

    }




    public function approve($id)
{

    $requestData = ExpenseRequest::findOrFail($id);



    // Update status pengajuan

    $requestData->update([

        'status'=>'approved'

    ]);




    // Simpan transaksi pengeluaran

    ExpenseTransaction::create([

        'request_id'=>$requestData->id,

        'approved_by'=>Auth::id(),

        'jumlah'=>$requestData->jumlah,

        'tanggal'=>now(),

    ]);





    // Kurangi saldo divisi

    $balance = DivisionBalance::where(
        'project_id',
        $requestData->project_id
    )
    ->where(
        'division_id',
        $requestData->division_id
    )
    ->first();



    if($balance)
    {

        $balance->decrement(
            'saldo',
            $requestData->jumlah
        );

    }



    return back()
        ->with(
            'success',
            'Pengajuan berhasil disetujui dan saldo diperbarui'
        );

}





    public function reject($id)
    {


        $requestData = ExpenseRequest::findOrFail($id);


        $requestData->update([

            'status'=>'rejected'

        ]);



        return back()
        ->with(
            'success',
            'Pengajuan ditolak'
        );


    }


}