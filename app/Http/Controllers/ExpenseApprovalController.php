<?php

namespace App\Http\Controllers;


use App\Models\PengajuanDana;
use App\Models\TransaksiDana;
use App\Models\SaldoDivisi;
use App\Models\RekeningBank;
use App\Models\Proyek;
use App\Models\Divisi;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use App\Notifications\ExpenseStatusNotification;
use App\Helpers\AuditHelper;



class ExpenseApprovalController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | HALAMAN APPROVAL KEUANGAN
    |--------------------------------------------------------------------------
    */


    public function index()
    {


        $requests = PengajuanDana::with([

            'proyek',

            'divisi',

            'pengguna'

        ])

        ->where(
            'status',
            'pending'
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









    /*
    |--------------------------------------------------------------------------
    | APPROVE PENGELUARAN
    |--------------------------------------------------------------------------
    */


    public function approve(Request $request,$id)
    {


        $request->validate([


            'rekening_bank_id'=>'required',


            'catatan_persetujuan'=>'nullable|string'


        ]);






        try{


            $expenseRequest = DB::transaction(function() use($request,$id){



                $expenseRequest = PengajuanDana::findOrFail($id);





                if($expenseRequest->status != 'pending')
                {

                    throw new \Exception(

                        'Pengajuan sudah diproses sebelumnya'

                    );

                }









                /*
                |--------------------------------------------------------------------------
                | CEK REKENING BANK
                |--------------------------------------------------------------------------
                */


                $bank = RekeningBank::findOrFail(

                    $request->rekening_bank_id

                );






                if($bank->saldo < $expenseRequest->jumlah)
                {

                    throw new \Exception(

                        'Saldo rekening tidak mencukupi'

                    );

                }









                /*
                |--------------------------------------------------------------------------
                | CEK SALDO DIVISI PROJECT
                |--------------------------------------------------------------------------
                */


                $balance = SaldoDivisi::where([


                    'proyek_id'=>$expenseRequest->proyek_id,


                    'divisi_id'=>$expenseRequest->divisi_id



                ])

                ->first();









                if(!$balance)
                {

                    throw new \Exception(

                        'Saldo divisi project belum tersedia'

                    );

                }









                if($balance->saldo < $expenseRequest->jumlah)
                {

                    throw new \Exception(

                        'Saldo divisi tidak mencukupi'

                    );

                }









                /*
                |--------------------------------------------------------------------------
                | UPDATE PENGAJUAN
                |--------------------------------------------------------------------------
                */


                $expenseRequest->update([



                    'status'=>'approved',



                    'disetujui_oleh'=>Auth::id(),



                    'disetujui_pada'=>now(),



                    'catatan_persetujuan'=>

                        $request->catatan_persetujuan

                        ??

                        'Disetujui oleh Keuangan'



                ]);









                /*
                |--------------------------------------------------------------------------
                | SIMPAN TRANSAKSI
                |--------------------------------------------------------------------------
                */


                TransaksiDana::create([



                    'pengajuan_dana_id'=>

                        $expenseRequest->id,



                    'disetujui_oleh'=>

                        Auth::id(),



                    'rekening_bank_id'=>

                        $bank->id,



                    'jumlah'=>

                        $expenseRequest->jumlah,



                    'tanggal'=>

                        now(),



                ]);









                /*
                |--------------------------------------------------------------------------
                | KURANGI SALDO BANK
                |--------------------------------------------------------------------------
                */


                $bank->decrement(

                    'saldo',

                    $expenseRequest->jumlah

                );









                /*
                |--------------------------------------------------------------------------
                | KURANGI SALDO DIVISI
                |--------------------------------------------------------------------------
                */


                $balance->decrement(

                    'saldo',

                    $expenseRequest->jumlah

                );









                return $expenseRequest;


            });









            /*
            |--------------------------------------------------------------------------
            | AUDIT
            |--------------------------------------------------------------------------
            */


            AuditHelper::create(

                'Approve Expense',

                'Finance',

                'Menyetujui pengajuan dana sebesar Rp ' .

                number_format(

                    $expenseRequest->jumlah,

                    0,

                    ',',

                    '.'

                )

            );









            /*
            |--------------------------------------------------------------------------
            | NOTIFIKASI
            |--------------------------------------------------------------------------
            */


            $expenseRequest->pengguna->notify(


                new ExpenseStatusNotification(

                    $expenseRequest,

                    'approved'

                )


            );









            return back()

            ->with(

                'success',

                'Pengajuan berhasil disetujui dan saldo berhasil diperbarui'

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
    | REJECT PENGELUARAN
    |--------------------------------------------------------------------------
    */


    public function reject(Request $request,$id)
    {


        $request->validate([


            'catatan_persetujuan'=>'required|string'


        ]);








        $expenseRequest = PengajuanDana::findOrFail($id);








        if($expenseRequest->status != 'pending')
        {


            return back()

            ->with(

                'error',

                'Pengajuan sudah diproses'

            );


        }









        $expenseRequest->update([



            'status'=>'rejected',



            'disetujui_oleh'=>Auth::id(),



            'disetujui_pada'=>now(),



            'catatan_persetujuan'=>

                $request->catatan_persetujuan



        ]);









        AuditHelper::create(

            'Reject Expense',

            'Finance',

            'Menolak pengajuan dana sebesar Rp ' .

            number_format(

                $expenseRequest->jumlah,

                0,

                ',',

                '.'

            )

            .

            ' dengan catatan: '

            .

            $request->catatan_persetujuan


        );









        $expenseRequest->pengguna->notify(


            new ExpenseStatusNotification(

                $expenseRequest,

                'rejected'

            )


        );









        return back()

        ->with(

            'success',

            'Pengajuan berhasil ditolak'

        );


    }









    /*
    |--------------------------------------------------------------------------
    | HISTORY APPROVAL
    |--------------------------------------------------------------------------
    */


    public function history(Request $request)
    {


        $query = PengajuanDana::with([


            'proyek',


            'divisi',


            'pengguna',


            'penyetuju'


        ])

        ->whereIn(

            'status',

            [

                'approved',

                'rejected'

            ]

        );









        if($request->search)
        {


            $query->whereHas(

                'pengguna',

                function($q) use($request){


                    $q->where(

                        'name',

                        'like',

                        '%'.$request->search.'%'

                    );


                }

            );


        }









        if($request->status)
        {


            $query->where(

                'status',

                $request->status

            );


        }









        if($request->proyek_id)
        {


            $query->where(

                'proyek_id',

                $request->proyek_id

            );


        }









        if($request->divisi_id)
        {


            $query->where(

                'divisi_id',

                $request->divisi_id

            );


        }









        $requests = $query

        ->latest()

        ->get();









        $projects = Proyek::all();


        $divisions = Divisi::all();









        return view(

            'expense.approval.history',

            compact(

                'requests',

                'projects',

                'divisions'

            )

        );


    }



}