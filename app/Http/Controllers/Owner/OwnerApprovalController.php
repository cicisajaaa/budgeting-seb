<?php

namespace App\Http\Controllers\Owner;


use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Models\ExpenseRequest;

use App\Helpers\AuditHelper;



class OwnerApprovalController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | DAFTAR PENGAJUAN MENUNGGU APPROVAL OWNER
    |--------------------------------------------------------------------------
    */


    public function index()
    {
$requests = ExpenseRequest::with([

    'user',

    'proyek',

    'division'

])

->latest()

->get();



$pendingRequests = ExpenseRequest::with([

    'user',

    'proyek',

    'division'

])

->where(
    'status',
    'pending'
)

->latest()

->get();


        return view(

            'owner.approval.index',

            compact('requests')

        );


    }








    /*
    |--------------------------------------------------------------------------
    | DETAIL PENGAJUAN
    |--------------------------------------------------------------------------
    */


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










    /*
    |--------------------------------------------------------------------------
    | APPROVE PENGAJUAN
    |--------------------------------------------------------------------------
    */


    public function approve($id)
    {


        $expense = ExpenseRequest::findOrFail($id);





        $expense->update([


            'status'=>'approved',


            'disetujui_oleh'=>auth()->id(),


            'disetujui_pada'=>now()


        ]);








        AuditHelper::create(

            'Approve Expense Request',

            'Approval Dana',

            'Owner menyetujui pengajuan dana sebesar Rp '.

            number_format(
                $expense->jumlah,
                0,
                ',',
                '.'
            )

        );








        return redirect()

            ->route(
                'owner.approval'
            )

            ->with(

                'success',

                'Pengajuan dana berhasil disetujui'

            );


    }









    /*
    |--------------------------------------------------------------------------
    | REJECT PENGAJUAN
    |--------------------------------------------------------------------------
    */


    public function reject(

        Request $request,

        $id

    )

    {


        $expense = ExpenseRequest::findOrFail($id);





        $expense->update([


            'status'=>'rejected',


            'disetujui_oleh'=>auth()->id(),


            'disetujui_pada'=>now(),


            'catatan_persetujuan'=>$request->catatan


        ]);








        AuditHelper::create(

            'Reject Expense Request',

            'Approval Dana',

            'Owner menolak pengajuan dana sebesar Rp '.

            number_format(
                $expense->jumlah,
                0,
                ',',
                '.'
            )

        );








        return redirect()

            ->route(
                'owner.approval'
            )

            ->with(

                'success',

                'Pengajuan dana ditolak'

            );


    }


}