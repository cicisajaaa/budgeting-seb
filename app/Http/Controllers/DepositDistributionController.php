<?php

namespace App\Http\Controllers;


use App\Models\DistribusiSetoran;


use Illuminate\Http\Request;
class DepositDistributionController extends Controller
{

public function index(Request $request)
{
    $query = DistribusiSetoran::with([
        'setoranProyek.proyek',
        'divisi'
    ]);

    /*
    |--------------------------------------------------------------------------
    | SEARCH
    |--------------------------------------------------------------------------
    */

    if ($request->filled('search')) {

        $search = trim($request->search);

        $query->where(function ($q) use ($search) {

            $q->whereHas(
                'divisi',
                function ($divisiQuery) use ($search) {

                    $divisiQuery->where(
                        'nama_divisi',
                        'like',
                        '%' . $search . '%'
                    );

                }
            );

            $q->orWhereHas(
                'setoranProyek.proyek',
                function ($projectQuery) use ($search) {

                    $projectQuery->where(
                        'nama_proyek',
                        'like',
                        '%' . $search . '%'
                    );

                }
            );

        });

    }


    $distributions = $query
        ->latest()
        ->get();


    /*
    |--------------------------------------------------------------------------
    | SUMMARY
    |--------------------------------------------------------------------------
    */

    $totalDistribution = $distributions->sum(
        'nominal_diterima'
    );


    $totalTransaction = $distributions->count();


    $totalDivision = $distributions
        ->pluck('divisi_id')
        ->unique()
        ->count();


    $totalProject = $distributions
        ->pluck('setoranProyek.proyek_id')
        ->filter()
        ->unique()
        ->count();


    return view(
        'finance.distribution.index',
        compact(
            'distributions',
            'totalDistribution',
            'totalTransaction',
            'totalDivision',
            'totalProject',
            'request'
        )
    );
}
}