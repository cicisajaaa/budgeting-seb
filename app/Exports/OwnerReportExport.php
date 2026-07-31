<?php

namespace App\Exports;

use App\Models\ProjectDeposit;
use App\Models\ExpenseRequest;
use App\Models\Project;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class OwnerReportExport implements FromCollection, WithHeadings
{


public function collection()
{


$data = collect();



$data->push([
    'Total Pendapatan',
   ProjectDeposit::sum('jumlah_setoran')
]);



$data->push([
    'Total Pengeluaran',
    ExpenseRequest::sum('jumlah')
]);



$data->push([
    'Profit Bersih',
    ProjectDeposit::sum('jumlah_setoran')
    -
    ExpenseRequest::sum('jumlah')
]);



$data->push([
    'Project Aktif',
    Project::where('progres_keseluruhan','<',100)->count()
]);




return $data;


}





public function headings(): array
{


return [

'Keterangan',

'Jumlah'

];


}


}