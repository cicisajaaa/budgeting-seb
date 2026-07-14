<?php

namespace App\Exports;

use App\Models\ProjectDeposit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class IncomeSheet implements FromCollection, WithHeadings
{

    public function collection()
    {

        return ProjectDeposit::with('project')
            ->get()
            ->map(function($item){

                return [

                    'tanggal' => $item->tanggal_setoran,

                    'project' => $item->project->nama_project ?? '-',

                    'jumlah' => $item->jumlah_setoran,

                ];

            });

    }



    public function headings(): array
    {

        return [

            'Tanggal',

            'Project',

            'Jumlah'

        ];

    }

}