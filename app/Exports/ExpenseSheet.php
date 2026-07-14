<?php

namespace App\Exports;


use App\Models\ExpenseTransaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class ExpenseSheet implements FromCollection, WithHeadings
{


    public function collection()
    {


        return ExpenseTransaction::with([
            'request.project',
            'request.division'
        ])
        ->get()
        ->map(function($item){


            return [

                $item->tanggal,

                $item->request->project->nama_project,

                $item->request->division->nama_divisi,

                $item->request->judul,

                $item->jumlah

            ];


        });


    }



    public function headings(): array
    {

        return [

            'Tanggal',

            'Project',

            'Divisi',

            'Keperluan',

            'Jumlah'

        ];

    }


}