<?php

namespace App\Exports;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class ProjectReportExport implements FromCollection, WithHeadings
{


public function collection()
{

return Project::select(
    'nama_proyek',
    'pemilik_proyek',
    'total_anggaran',
    'progres_keseluruhan',
    'tanggal_selesai'
)->get();

}



public function headings(): array
{

return [

'Nama Project',
'Pemilik / Client',
'Total Anggaran',
'Progress (%)',
'Tanggal Selesai'

];

}


}