<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

use App\Models\Proyek;
use App\Models\Divisi;
use App\Models\AlokasiProyekDivisi;
use App\Models\SaldoDivisi;
use App\Models\DistribusiSetoran;


use Illuminate\Http\Request;



class AllocationController extends Controller
{


    public function index($project)
    {


        $project = Proyek::findOrFail($project);



        $allocations = AlokasiProyekDivisi::with([
            'divisi'
        ])
        ->where(
            'proyek_id',
            $project->id
        )
        ->latest()
        ->get();




        $divisions = Divisi::latest()->get();




        return view(
            'admin.allocation.index',
            compact(
                'project',
                'allocations',
                'divisions'
            )
        );


    }




public function store(Request $request, $project)
{
    $project = Proyek::findOrFail($project);

    // Cek apakah proyek sudah pernah menerima setoran
    $hasDeposit = \App\Models\SetoranProyek::where(
        'proyek_id',
        $project->id
    )->exists();

    if ($hasDeposit)
    {
        return back()
            ->with(
                'error',
                'Alokasi dana tidak dapat ditambahkan karena proyek sudah memiliki transaksi setoran.'
            );
    }

    $request->validate([

        'divisi_id' => [
            'required',
            'exists:divisi,id',
        ],

        'persentase' => [
            'required',
            'numeric',
            'min:1',
            'max:100'
        ]

    ]);

    $cekDivisi = AlokasiProyekDivisi::where([

        'proyek_id' => $project->id,

        'divisi_id' => $request->divisi_id

    ])
    ->exists();

    if ($cekDivisi)
    {
        return back()
            ->with(
                'error',
                'Divisi tersebut sudah memiliki alokasi dana'
            );
    }

    $total = AlokasiProyekDivisi::where(
        'proyek_id',
        $project->id
    )
    ->sum('persentase');

    if ($total + $request->persentase > 100)
    {
        return back()
            ->with(
                'error',
                'Total pembagian dana melebihi 100%'
            );
    }

    AlokasiProyekDivisi::create([

        'proyek_id' => $project->id,

        'divisi_id' => $request->divisi_id,

        'persentase' => $request->persentase,

    ]);

    return back()
        ->with(
            'success',
            'Pembagian dana berhasil ditambahkan'
        );
}




    public function edit($id)
    {


        $allocation = AlokasiProyekDivisi::findOrFail($id);



        $project = Proyek::findOrFail(
            $allocation->proyek_id
        );



        $divisions = Divisi::latest()->get();





        return view(

            'admin.allocation.edit',

            compact(

                'allocation',

                'project',

                'divisions'

            )

        );


    }






public function update(Request $request,$id)
{
    $allocation = AlokasiProyekDivisi::findOrFail($id);

    $usedSaldo = SaldoDivisi::where([
        'proyek_id' => $allocation->proyek_id,
        'divisi_id' => $allocation->divisi_id
    ])->exists();

    $usedDistribution = DistribusiSetoran::where(
        'divisi_id',
        $allocation->divisi_id
    )
    ->whereHas('setoranProyek', function ($query) use ($allocation) {
        $query->where('proyek_id', $allocation->proyek_id);
    })
    ->exists();

    if($usedSaldo || $usedDistribution)
    {
        return back()
            ->with(
                'error',
                'Alokasi tidak dapat diubah karena sudah digunakan dalam transaksi dana.'
            );
    }

    $request->validate([

        'divisi_id'=>[
            'required',
            'exists:divisi,id'
        ],

        'persentase'=>[
            'required',
            'numeric',
            'min:1',
            'max:100'
        ]

    ]);

    $cekDivisi = AlokasiProyekDivisi::where(
        'proyek_id',
        $allocation->proyek_id
    )
    ->where(
        'divisi_id',
        $request->divisi_id
    )
    ->where(
        'id',
        '!=',
        $allocation->id
    )
    ->exists();

    if($cekDivisi)
    {
        return back()
            ->withErrors([
                'divisi_id' =>
                    'Divisi tersebut sudah memiliki alokasi dana.'
            ])
            ->withInput();
    }

    $totalLain = AlokasiProyekDivisi::where(
        'proyek_id',
        $allocation->proyek_id
    )
    ->where(
        'id',
        '!=',
        $allocation->id
    )
    ->sum('persentase');

    if($totalLain + $request->persentase > 100)
    {
        return back()
            ->withErrors([
                'persentase' =>
                    'Total pembagian dana melebihi 100%.'
            ])
            ->withInput();
    }

    $allocation->update([

        'divisi_id'=>$request->divisi_id,

        'persentase'=>$request->persentase,

    ]);

    return redirect()
        ->route(
            'admin.allocation.index',
            $allocation->proyek_id
        )
        ->with(
            'success',
            'Alokasi dana berhasil diperbarui'
        );
}





public function destroy($allocation)
{
    $allocation = AlokasiProyekDivisi::findOrFail($allocation);

    $usedSaldo = SaldoDivisi::where([
        'proyek_id' => $allocation->proyek_id,
        'divisi_id' => $allocation->divisi_id
    ])->exists();

    $usedDistribution = DistribusiSetoran::where('divisi_id', $allocation->divisi_id)
        ->whereHas('setoranProyek', function ($query) use ($allocation) {
            $query->where('proyek_id', $allocation->proyek_id);
        })
        ->exists();

    if($usedSaldo || $usedDistribution)
    {
        return back()
            ->with(
                'error',
                'Alokasi tidak dapat dihapus karena sudah digunakan dalam transaksi dana.'
            );
    }

    $allocation->delete();

    return back()
        ->with(
            'success',
            'Alokasi berhasil dihapus'
        );
}
}