<?php

namespace App\Http\Controllers;


use App\Models\BankAccount;
use Illuminate\Http\Request;



class BankAccountController extends Controller
{


    public function index()
    {


        $banks = BankAccount::latest()
            ->get();



        return view(
            'finance.bank.index',
            compact('banks')
        );


    }







    public function create()
    {


        return view(
            'finance.bank.create'
        );


    }








    public function store(Request $request)
    {


        $request->validate([


            'nama_bank'=>'required',


            'nomor_rekening'=>'required|unique:bank_accounts',


            'nama_pemilik'=>'required',


        ]);





        BankAccount::create([


            'nama_bank'=>$request->nama_bank,


            'nomor_rekening'=>$request->nomor_rekening,


            'nama_pemilik'=>$request->nama_pemilik,


            'saldo'=>0,


            'status'=>true,


        ]);






        return redirect()
            ->route('finance.bank.index')
            ->with(
                'success',
                'Rekening bank berhasil ditambahkan'
            );


    }









    public function edit($id)
    {


        $bank = BankAccount::findOrFail($id);



        return view(
            'finance.bank.edit',
            compact('bank')
        );


    }









    public function update(Request $request,$id)
    {


        $bank = BankAccount::findOrFail($id);



        $request->validate([


            'nama_bank'=>'required',


            'nomor_rekening'=>'required',


            'nama_pemilik'=>'required',


        ]);





        $bank->update([


            'nama_bank'=>$request->nama_bank,


            'nomor_rekening'=>$request->nomor_rekening,


            'nama_pemilik'=>$request->nama_pemilik,


        ]);






        return redirect()
            ->route('finance.bank.index')
            ->with(
                'success',
                'Rekening berhasil diperbarui'
            );


    }









    public function destroy($id)
    {


        $bank = BankAccount::findOrFail($id);



        $bank->delete();




        return back()
            ->with(
                'success',
                'Rekening berhasil dihapus'
            );


    }



}