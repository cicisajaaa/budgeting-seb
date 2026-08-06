<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\LogAudit;
use Illuminate\Http\Request;



class OwnerAuditController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | AUDIT TERBARU (5 DATA)
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {


        $query = LogAudit::with('pengguna');



        if($request->modul)
        {

            $query->where(
                'modul',
                $request->modul
            );

        }




        if($request->tanggal)
        {

            $query->whereDate(
                'created_at',
                $request->tanggal
            );

        }





        $activities = $query

            ->latest()

            ->limit(5)

            ->get();







        return view(

            'owner.audit.index',

            compact(
                'activities'
            )

        );


    }








    /*
    |--------------------------------------------------------------------------
    | RIWAYAT AUDIT LENGKAP
    |--------------------------------------------------------------------------
    */

    public function history(Request $request)
{


    $activities = LogAudit::selectRaw(
        'DATE(created_at) as tanggal, COUNT(*) as total'
    )
    ->groupBy('tanggal')
    ->orderByDesc('tanggal')
    ->get();



    return view(
        'owner.audit.history',
        compact('activities')
    );


}


public function date($tanggal)
{


    $activities = LogAudit::with('pengguna')
        ->whereDate(
            'created_at',
            $tanggal
        )
        ->latest()
        ->get();



    return view(
        'owner.audit.date',
        compact(
            'activities',
            'tanggal'
        )
    );


}
}