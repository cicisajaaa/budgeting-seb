<?php

namespace App\Http\Controllers;


use App\Models\PengajuanDana;
use App\Models\TransaksiDana;
use App\Models\SaldoDivisi;
use App\Models\RekeningBank;
use App\Models\Proyek;
use App\Models\MutasiKeuangan;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use App\Notifications\ExpenseStatusNotification;

use App\Helpers\AuditHelper;



class ExpenseApprovalController extends Controller
{


    private function checkRole()
    {

        if(
            !in_array(
                Auth::user()->role,
                [
                    'admin',
                    'keuangan',
                    'owner'
                ]
            )
        )
        {
            abort(403);
        }

    }








    public function index()
    {


        $this->checkRole();



        $requests = PengajuanDana::with([

            'proyek.perusahaan',
            'divisi',
            'pengguna'

        ])

        ->whereIn(

            'status',

            [
                'pending',
                'approved',
                'selesai'
            ]

        )

        ->latest()

        ->get();




        $banks = RekeningBank::where(

            'status',

            true

        )

        ->get();




        return view(

            'expense.approval.index',

            compact(

                'requests',

                'banks'

            )

        );

    }












    public function approve(
        Request $request,
        $id
    )
    {


        $this->checkRole();




        $request->validate([

            'catatan_persetujuan'
                =>'nullable|string'

        ]);





        try {


            $expenseRequest = DB::transaction(function() use(
                $request,
                $id
            ){

                $expenseRequest =
                    PengajuanDana::lockForUpdate()
                    ->findOrFail($id);





                if(
                    $expenseRequest->status != 'pending'
                )
                {

                    throw new \Exception(
                        'Pengajuan sudah diproses.'
                    );

                }






                $project = Proyek::findOrFail(

                    $expenseRequest->proyek_id

                );






                if(
                    $project->sisa_budget <
                    $expenseRequest->jumlah
                )
                {

                    throw new \Exception(
                        'Budget project tidak mencukupi.'
                    );

                }







                $expenseRequest->update([


                    'status'=>'approved',


                    'disetujui_oleh'=>Auth::id(),


                    'disetujui_pada'=>now(),


                    'catatan_persetujuan'=>

                    $request->catatan_persetujuan

                    ??

                    'Disetujui oleh '
                    .Auth::user()->name


                ]);





                return $expenseRequest;


            });







            AuditHelper::create(

                'APPROVE',

                'Pengajuan Dana',

                'Menyetujui pengajuan dana '.
                $expenseRequest->judul,

                $expenseRequest->id

            );







            $expenseRequest->pengguna->notify(

                new ExpenseStatusNotification(

                    $expenseRequest,

                    'approved'

                )

            );







            return back()->with(

                'success',

                'Pengajuan berhasil disetujui'

            );



        }

        catch(\Exception $e)

        {

            return back()->with(

                'error',

                $e->getMessage()

            );

        }


    }













    public function disburse(
        Request $request,
        $id
    )
    {


        $this->checkRole();





        $request->validate([

        'rekening_bank_id'=>[
            'required',
            'exists:rekening_bank,id'
        ]

        ]);







        try {


            DB::transaction(function() use(
                $request,
                $id
            ){




                $expenseRequest =

                PengajuanDana::lockForUpdate()

                ->findOrFail($id);






                if(
                    $expenseRequest->status != 'approved'
                )
                {

                    throw new \Exception(
                        'Pengajuan belum siap dicairkan.'
                    );

                }







                $bank = RekeningBank::where(

                    'id',

                    $request->rekening_bank_id

                )

                ->where(

                    'status',

                    true

                )

                ->lockForUpdate()

                ->firstOrFail();








                if(
                    $bank->saldo <
                    $expenseRequest->jumlah
                )
                {

                    throw new \Exception(
                        'Saldo rekening tidak mencukupi.'
                    );

                }







                $balance = SaldoDivisi::where([

                    'proyek_id'=>
                    $expenseRequest->proyek_id,


                    'divisi_id'=>
                    $expenseRequest->divisi_id


                ])

                ->lockForUpdate()

                ->firstOrFail();







                if(
                    $balance->saldo <
                    $expenseRequest->jumlah
                )
                {

                    throw new \Exception(
                        'Saldo divisi tidak mencukupi.'
                    );

                }








if(
    TransaksiDana::where(
        'pengajuan_dana_id',
        $expenseRequest->id
    )
    ->lockForUpdate()
    ->exists()
)
                {

                    throw new \Exception(
                        'Dana sudah pernah dicairkan.'
                    );

                }







                $transaction = TransaksiDana::create([


                    'pengajuan_dana_id'=>
                    $expenseRequest->id,


                    'disetujui_oleh'=>
                    Auth::id(),


                    'rekening_bank_id'=>
                    $bank->id,


                    'jumlah'=>
                    $expenseRequest->jumlah,


                    'tanggal'=>now()


                ]);









                MutasiKeuangan::create([


                    'rekening_bank_id'=>
                    $bank->id,


                    'jenis'=>'keluar',


                    'nominal'=>
                    $expenseRequest->jumlah,


                    'referensi_type'=>
                    'transaksi_dana',


                    'referensi_id'=>
                    $transaction->id,


                    'tanggal'=>now(),


                    'keterangan'=>
                    'Pencairan dana '
                    .$expenseRequest->judul,


                    'created_by'=>
                    Auth::id()


                ]);







                $bank->decrement(

                    'saldo',

                    $expenseRequest->jumlah

                );







                $balance->decrement(

                    'saldo',

                    $expenseRequest->jumlah

                );







                $expenseRequest->update([


                    'status'=>'selesai',


                    'disetujui_pada'=>now()


                ]);








                AuditHelper::create(

                    'DISBURSE',

                    'Pengajuan Dana',

                    'Pencairan dana '
                    .$expenseRequest->judul,

                    $expenseRequest->id

                );



            });







            return back()->with(

                'success',

                'Dana berhasil dicairkan'

            );



        }


        catch(\Exception $e)

        {

            return back()->with(

                'error',

                $e->getMessage()

            );

        }


    }













    public function reject(
        Request $request,
        $id
    )
    {


        $this->checkRole();





        $request->validate([

            'catatan_persetujuan'
            =>'required|string'

        ]);







        try {


            $expenseRequest = DB::transaction(function() use(
                $request,
                $id
            ){

                $expenseRequest =

                PengajuanDana::lockForUpdate()

                ->findOrFail($id);





                if(
                    $expenseRequest->status != 'pending'
                )
                {

                    throw new \Exception(
                        'Pengajuan sudah diproses.'
                    );

                }






                $expenseRequest->update([


                    'status'=>'rejected',


                    'disetujui_oleh'=>Auth::id(),


                    'disetujui_pada'=>now(),


                    'catatan_persetujuan'=>
                    $request->catatan_persetujuan


                ]);






                return $expenseRequest;


            });







            AuditHelper::create(

                'REJECT',

                'Pengajuan Dana',

                'Menolak pengajuan dana '
                .$expenseRequest->judul,

                $expenseRequest->id

            );







            $expenseRequest->pengguna->notify(

                new ExpenseStatusNotification(

                    $expenseRequest,

                    'rejected'

                )

            );








            return back()->with(

                'success',

                'Pengajuan dana ditolak'

            );



        }


        catch(\Exception $e)

        {

            return back()->with(

                'error',

                $e->getMessage()

            );

        }


    }


public function history()
{
    $this->checkRole();

    $requests = PengajuanDana::with([
        'proyek.perusahaan',
        'divisi',
        'pengguna',
        'penyetuju',
        'transaksiDana.rekeningBank'
    ])
    ->whereIn('status', [
        'approved',
        'selesai',
        'rejected'
    ])
    ->latest()
    ->get();

    return view(
        'expense.approval.history',
        compact('requests')
    );
}


public function detail($id)
{
    $this->checkRole();

    $request = PengajuanDana::with([
        'proyek.perusahaan',
        'divisi',
        'pengguna',
        'penyetuju',
        'transaksiDana.rekeningBank',
        'auditLogs.pengguna'
    ])->findOrFail($id);

    return view(
        'expense.detail',
        compact('request')
    );
}
}