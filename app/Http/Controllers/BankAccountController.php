<?php

namespace App\Http\Controllers;


use App\Models\RekeningBank;

use Illuminate\Http\Request;



class BankAccountController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | LIST REKENING BANK
    |---------------------------------------------------------------------------
    */

public function index()
{

    $banks = RekeningBank::latest()->get();


    $totalBank = $banks->count();

    $totalSaldo = $banks->sum(function ($bank) {
    return $bank->saldoAktual();
});

    $bankAktif = $banks
        ->where('status', true)
        ->count();

    $bankNonAktif = $banks
        ->where('status', false)
        ->count();



    return view(
        'finance.bank.index',
        compact(
            'banks',
            'totalBank',
            'totalSaldo',
            'bankAktif',
            'bankNonAktif'
        )
    );

}



    /*
    |--------------------------------------------------------------------------
    | FORM TAMBAH BANK
    |--------------------------------------------------------------------------
    */


    public function create()
    {


        return view(

            'finance.bank.create'

        );


    }









    /*
    |--------------------------------------------------------------------------
    | SIMPAN BANK
    |--------------------------------------------------------------------------
    */


    public function store(Request $request)
    {


        $request->validate([



            'nama_bank'=>'required|string|max:255',



            'nomor_rekening'=>'required|string|max:255',



            'nama_pemilik'=>'required|string|max:255',



            'saldo'=>'required|numeric',



            'status'=>'required'

        ]);






RekeningBank::create([

    'nama_bank' => $request->nama_bank,

    'nomor_rekening' => $request->nomor_rekening,

    'nama_pemilik' => $request->nama_pemilik,

    'saldo_awal' => $request->saldo,

    'saldo' => $request->saldo,

    'status' => $request->status

]);



        return redirect()

            ->route(

                'finance.bank.index'

            )

            ->with(

                'success',

                'Rekening bank berhasil ditambahkan'

            );


    }









    /*
    |--------------------------------------------------------------------------
    | DETAIL BANK
    |--------------------------------------------------------------------------
    */


    public function show(RekeningBank $bank)
    {


        return view(

            'finance.bank.show',

            compact(

                'bank'

            )

        );


    }









    /*
    |--------------------------------------------------------------------------
    | EDIT BANK
    |--------------------------------------------------------------------------
    */


    public function edit(RekeningBank $bank)
    {


        return view(

            'finance.bank.edit',

            compact(

                'bank'

            )

        );


    }









    /*
    |--------------------------------------------------------------------------
    | UPDATE BANK
    |--------------------------------------------------------------------------
    */


   public function update(Request $request, RekeningBank $bank)
{


$request->validate([

    'nama_bank' => 'required|string|max:255',

    'nomor_rekening' => 'required|string|max:255',

    'nama_pemilik' => 'required|string|max:255',

    'saldo_awal' => 'required|numeric|min:0',

    'status' => 'required'

]);




$bank->update([

    'nama_bank' => $request->nama_bank,

    'nomor_rekening' => $request->nomor_rekening,

    'nama_pemilik' => $request->nama_pemilik,

    'saldo_awal' => $request->saldo_awal,

    'status' => $request->status

]);





    return redirect()

        ->route('finance.bank.index')

        ->with(

            'success',

            'Rekening bank berhasil diperbarui'

        );


}








    /*
    |--------------------------------------------------------------------------
    | HAPUS BANK
    |--------------------------------------------------------------------------
    */
public function destroy(RekeningBank $bank)
{
    $jumlahMutasi = $bank->mutasiKeuangan()->count();

    if ($jumlahMutasi > 0) {
        return redirect()
            ->route('finance.bank.index')
            ->with(
                'error',
                'Rekening '.$bank->nama_bank.' tidak dapat dihapus karena memiliki '.$jumlahMutasi.' histori transaksi keuangan. Silakan nonaktifkan rekening.'
            );
    }

    $bank->delete();

    return redirect()
        ->route('finance.bank.index')
        ->with(
            'success',
            'Rekening bank berhasil dihapus'
        );
}

}