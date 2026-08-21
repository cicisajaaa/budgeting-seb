<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\PengajuanDana;
use App\Models\TransaksiDana;

use Illuminate\Http\Request;


class PengajuanDanaController extends Controller
{


    public function index()
    {

        $pengajuan = PengajuanDana::with([

            'pengguna',

            'proyek',

            'divisi'

        ])

        ->latest()

        ->get();


        return view(

            'admin.pengajuan-dana.index',

            compact('pengajuan')

        );

    }




    public function approve(
        PengajuanDana $pengajuan
    )
    {


        $pengajuan->update([

            'status'=>'approved',

            'disetujui_oleh'=>auth()->id(),

            'disetujui_pada'=>now()

        ]);



        TransaksiDana::create([

            'pengajuan_dana_id'=>$pengajuan->id,

            'disetujui_oleh'=>auth()->id(),

            'jumlah'=>$pengajuan->jumlah,

            'tanggal'=>now()

        ]);



        return back()->with(

            'success',

            'Pengajuan dana berhasil disetujui'

        );


    }




    public function reject(
        Request $request,
        PengajuanDana $pengajuan
    )
    {


        $pengajuan->update([

            'status'=>'rejected',

            'disetujui_oleh'=>auth()->id(),

            'disetujui_pada'=>now(),

            'catatan_persetujuan'=>$request->catatan

        ]);



        return back()->with(

            'success',

            'Pengajuan dana ditolak'

        );


    }


}