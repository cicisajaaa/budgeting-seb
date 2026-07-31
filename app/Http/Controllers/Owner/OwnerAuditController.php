<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\LogAudit;
use Illuminate\Http\Request;


class OwnerAuditController extends Controller
{


public function index(Request $request)
{


    $query = LogAudit::with('pengguna');



    if($request->modul){


        $query->where(
            'modul',
            $request->modul
        );


    }




    if($request->tanggal){


        $query->whereDate(
            'created_at',
            $request->tanggal
        );


    }





    $activities = $query
        ->latest()
        ->get();




    return view(
        'owner.audit.index',
        compact('activities')
    );


}



}