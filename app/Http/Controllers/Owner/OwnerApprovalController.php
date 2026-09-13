<?php

namespace App\Http\Controllers\Owner;


use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


use App\Http\Controllers\Controller;


use App\Models\PengajuanDana;


use App\Helpers\AuditHelper;


use App\Notifications\ExpenseStatusNotification;




class OwnerApprovalController extends Controller
{


    private function checkRole()
    {

        if(
            Auth::user()->role !== 'owner'
        )
        {
            abort(403);
        }

    }








    /*
    |--------------------------------------------------------------------------
    | DAFTAR PENGAJUAN OWNER
    |--------------------------------------------------------------------------
    */


    public function index()
    {


        $this->checkRole();




        $requests = PengajuanDana::with([

            'pengguna',

            'proyek',

            'divisi'

        ])

        ->latest()

        ->get();






        return view(

            'owner.approval.index',

            compact(
                'requests'
            )

        );


    }









    /*
    |--------------------------------------------------------------------------
    | DETAIL PENGAJUAN
    |--------------------------------------------------------------------------
    */


    public function detail($id)
    {


        $this->checkRole();




        $expense = PengajuanDana::with([

            'pengguna',

            'proyek',

            'divisi'

        ])

        ->findOrFail($id);






        return view(

            'owner.approval.detail',

            compact(
                'expense'
            )

        );


    }









    /*
    |--------------------------------------------------------------------------
    | APPROVE
    |--------------------------------------------------------------------------
    */


    public function approve($id)
    {


        $this->checkRole();





        try {


            $expense = DB::transaction(function() use($id){




                $expense = PengajuanDana::lockForUpdate()

                    ->findOrFail($id);






                if(
                    $expense->status !== 'pending'
                )
                {

                    throw new \Exception(

                        'Pengajuan sudah diproses.'

                    );

                }








                $expense->update([


                    'status'=>'approved',


                    'disetujui_oleh'=>Auth::id(),


                    'disetujui_pada'=>now()


                ]);







                return $expense;



            });









            AuditHelper::create(

                'APPROVE',

                'Approval Dana',

                'Owner menyetujui pengajuan dana '.

                $expense->judul.

                ' sebesar Rp '.

                number_format(

                    $expense->jumlah,

                    0,

                    ',',

                    '.'

                ),

                $expense->id

            );









            $expense->pengguna->notify(

                new ExpenseStatusNotification(

                    $expense,

                    'approved'

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


        catch(\Exception $e)

        {

            return back()

                ->with(

                    'error',

                    $e->getMessage()

                );

        }


    }









    /*
    |--------------------------------------------------------------------------
    | REJECT
    |--------------------------------------------------------------------------
    */


    public function reject(

        Request $request,

        $id

    )
    {


        $this->checkRole();





        $request->validate([

            'catatan'=>'required|string'

        ]);








        try {


            $expense = DB::transaction(function() use(
                $request,
                $id
            ){



                $expense = PengajuanDana::lockForUpdate()

                    ->findOrFail($id);







                if(
                    $expense->status !== 'pending'
                )
                {

                    throw new \Exception(

                        'Pengajuan sudah diproses.'

                    );

                }







                $expense->update([



                    'status'=>'rejected',



                    'disetujui_oleh'=>Auth::id(),



                    'disetujui_pada'=>now(),



                    'catatan_persetujuan'=>

                        $request->catatan



                ]);







                return $expense;



            });









            AuditHelper::create(

                'REJECT',

                'Approval Dana',

                'Owner menolak pengajuan dana '.

                $expense->judul.

                ' sebesar Rp '.

                number_format(

                    $expense->jumlah,

                    0,

                    ',',

                    '.'

                ),

                $expense->id

            );









            $expense->pengguna->notify(

                new ExpenseStatusNotification(

                    $expense,

                    'rejected'

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


        catch(\Exception $e)

        {

            return back()

                ->with(

                    'error',

                    $e->getMessage()

                );

        }


    }



}