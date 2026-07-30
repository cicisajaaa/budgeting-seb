<?php

namespace App\Http\Controllers;


use App\Models\Proyek;
use App\Models\SetoranProyek;
use App\Models\DistribusiSetoran;
use App\Models\SaldoDivisi;
use App\Models\RekeningBank;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class FinanceDepositController extends Controller
{

public function index()
{


    $deposits = SetoranProyek::with([

        'proyek',

        'rekeningBank'

    ])

    ->latest()

    ->get();



    // TOTAL PEMBAYARAN MASUK

    $totalDeposit = $deposits->sum('jumlah_setoran');



    // JUMLAH TRANSAKSI

    $totalTransaction = $deposits->count();



    // JUMLAH PROJECT YANG SUDAH BAYAR

    $totalProject = $deposits

        ->pluck('proyek_id')

        ->unique()

        ->count();



    // JUMLAH BANK YANG DIGUNAKAN

    $totalBank = $deposits

        ->pluck('rekening_bank_id')

        ->unique()

        ->count();





    return view(

        'finance.deposit.index',

        compact(

            'deposits',

            'totalDeposit',

            'totalTransaction',

            'totalProject',

            'totalBank'

        )

    );


}


    public function create()
    {
        $projects = Proyek::all();

        $banks = RekeningBank::where(
            'status',
            true
        )->get();

        return view('finance.deposit.create', compact(
            'projects',
            'banks'
        ));
    }



    public function store(Request $request)
    {


        $request->validate([


            'proyek_id' => 'required|exists:proyek,id',


            'rekening_bank_id' => 'required|exists:rekening_bank,id',


            'jumlah_setoran' => 'required|numeric',


            'tanggal_setoran' => 'required|date',


        ]);






        DB::transaction(function () use ($request) {



            /*
            |--------------------------------------------------------------------------
            | SIMPAN SETORAN PROYEK
            |--------------------------------------------------------------------------
            */


            $deposit = SetoranProyek::create([


                'proyek_id' => $request->proyek_id,


                'rekening_bank_id' => $request->rekening_bank_id,


                'jumlah_setoran' => $request->jumlah_setoran,


                'tanggal_setoran' => $request->tanggal_setoran,


            ]);







            /*
            |--------------------------------------------------------------------------
            | UPDATE SALDO BANK
            |--------------------------------------------------------------------------
            */


            $bank = RekeningBank::findOrFail(

                $request->rekening_bank_id

            );




            $bank->increment(

                'saldo',

                $request->jumlah_setoran

            );








            /*
            |--------------------------------------------------------------------------
            | AMBIL ALOKASI DIVISI PROYEK
            |--------------------------------------------------------------------------
            */


            $allocations = $deposit

                ->proyek

                ->alokasiDivisi;









            /*
            |--------------------------------------------------------------------------
            | DISTRIBUSI DANA
            |--------------------------------------------------------------------------
            */


            foreach($allocations as $allocation)
            {



                $nominal =


                    $deposit->jumlah_setoran

                    *

                    (

                        $allocation->persentase

                        /

                        100

                    );









                DistribusiSetoran::create([


                    'setoran_proyek_id' => $deposit->id,


                    'divisi_id' => $allocation->divisi_id,


                    'nominal_diterima' => $nominal,


                ]);









                /*
                |--------------------------------------------------------------------------
                | UPDATE SALDO DIVISI
                |--------------------------------------------------------------------------
                */


                $balance = SaldoDivisi::firstOrCreate(



                    [


                        'proyek_id' => $deposit->proyek_id,


                        'divisi_id' => $allocation->divisi_id,


                    ],



                    [


                        'saldo' => 0


                    ]



                );







                $balance->increment(

                    'saldo',

                    $nominal

                );





            }



        });









        return redirect()

            ->back()

            ->with(

                'success',

                'Pembayaran berhasil disimpan, saldo bank dan divisi berhasil diperbarui'

            );



    }



}