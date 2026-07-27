<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyek;
use App\Models\Divisi;
use App\Models\PengajuanDana;
use App\Models\User;
use App\Models\SaldoDivisi;
use App\Models\LogAudit;


use App\Notifications\NewExpenseRequest;


use App\Http\Requests\StorePengajuanDanaRequest;
use Illuminate\Support\Facades\Auth;



class ExpenseRequestController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | FORM PENGAJUAN DANA
    |--------------------------------------------------------------------------
    */


    public function create()
    {


        $projects = Proyek::all();


        $divisions = Divisi::all();




        return view(

            'expense.create',

            compact(

                'projects',

                'divisions'

            )

        );


    }









    /*
    |--------------------------------------------------------------------------
    | SIMPAN PENGAJUAN DANA
    |--------------------------------------------------------------------------
    */


    public function store(StorePengajuanDanaRequest $request)
    {
$balance = SaldoDivisi::where([

    'proyek_id' => $request->proyek_id,

    'divisi_id' => $request->divisi_id

])->first();


if(!$balance)
{

    return back()

    ->withErrors([

        'jumlah' => 'Saldo divisi belum tersedia'

    ])

    ->withInput();

}



if($balance->saldo < $request->jumlah)
{

    return back()

    ->withErrors([

        'jumlah' => 'Saldo divisi tidak mencukupi'

    ])

    ->withInput();

}

       







        /*
        |--------------------------------------------------------------------------
        | SIMPAN PENGAJUAN
        |--------------------------------------------------------------------------
        */
$filename = null;


if($request->hasFile('bukti_pengajuan'))
{

    $file = $request->file('bukti_pengajuan');


    $filename = time().'_'.$file->getClientOriginalName();


    $file->move(

        public_path('uploads/pengajuan'),

        $filename

    );

}

        $expense = PengajuanDana::create([



            'proyek_id'=>$request->proyek_id,



            'divisi_id'=>$request->divisi_id,



            'pengguna_id'=>Auth::id(),



            'judul'=>$request->judul,



            'keterangan'=>$request->keterangan,



            'jumlah'=>$request->jumlah,



            'status'=>'pending',

            'bukti_pengajuan'=>$filename,

        ]);
LogAudit::create([

    'pengguna_id' => Auth::id(),

    'pengajuan_dana_id' => $expense->id,

    'aksi' => 'CREATE',

    'modul' => 'Pengajuan Dana',

    'deskripsi' => 'Membuat pengajuan dana: '.$expense->judul,

    'alamat_ip' => request()->ip(),

]);








        /*
        |--------------------------------------------------------------------------
        | NOTIFIKASI KEUANGAN
        |--------------------------------------------------------------------------
        */


        $keuangan = User::where(

            'role',

            'keuangan'

        )

        ->get();








        foreach($keuangan as $user)
        {


            $user->notify(

                new NewExpenseRequest($expense)

            );


        }









        return back()

        ->with(

            'success',

            'Pengajuan dana berhasil dikirim dan menunggu persetujuan keuangan'

        );


    }









    /*
    |--------------------------------------------------------------------------
    | HISTORY PENGAJUAN KARYAWAN
    |--------------------------------------------------------------------------
    */


   public function history(Request $request)
{

    $query = PengajuanDana::with([

        'proyek',

        'divisi',

        'penyetuju'

    ])

    ->where(

        'pengguna_id',

        Auth::id()

    );


    if($request->filled('status'))
    {

        $query->where(

            'status',

            $request->status

        );

    }



    $requests = $query

        ->latest()

        ->get();



    return view(

        'expense.history',

        compact(

            'requests'

        )

    );

}
public function detail($id)
{

    $request = PengajuanDana::with([

        'proyek',

        'divisi',

        'penyetuju',

        'auditLogs'

    ])

    ->where(

        'pengguna_id',

        Auth::id()

    )

    ->findOrFail($id);



    return view(

        'expense.detail',

        compact('request')

    );

}

}