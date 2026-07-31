<?php

namespace App\Exports;


use App\Models\Project;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class PerformanceReportExport implements FromCollection, WithHeadings
{


public function collection()
{

return collect([

[

'total_project'=>Project::count(),

'project_aktif'=>Project::where(
    'progres_keseluruhan',
    '<',
    100
)->count(),


'rata_progress'=>Project::avg(
    'progres_keseluruhan'
) ?? 0


]

]);


}




public function headings(): array
{

return [

'Total Project',
'Project Aktif',
'Rata-rata Progress'

];


}



}