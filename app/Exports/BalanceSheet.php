<?php

namespace App\Exports;


use App\Models\DivisionBalance;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;



class BalanceSheet implements FromCollection, WithHeadings
{


    public function collection()
    {


        return DivisionBalance::with('division')
        ->get()
        ->map(function($item){


            return [

                $item->division->nama_divisi,

                $item->saldo

            ];


        });


    }



    public function headings(): array
    {

        return [

            'Divisi',

            'Saldo'

        ];

    }


}