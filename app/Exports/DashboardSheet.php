<?php

namespace App\Exports;


use App\Models\Proyek;
use App\Models\SetoranProyek;
use App\Models\TransaksiDana;


use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;


use Maatwebsite\Excel\Events\AfterSheet;


use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;



class DashboardSheet implements

    FromArray,

    WithEvents,

    WithDrawings,

    WithTitle,

    WithCustomStartCell

{
protected $startDate;

protected $endDate;

public function __construct(
    $startDate = null,
    $endDate = null
)
{

    $this->startDate = $startDate;

    $this->endDate = $endDate;

}

    public function title(): string
    {
        return 'Dashboard';
    }





    public function startCell(): string
    {
        return 'A6';
    }








public function array(): array
{


    $project = Proyek::when(

        $this->startDate,

        function($query){

            $query->whereDate(
                'created_at',
                '>=',
                $this->startDate
            );

        }

    )

    ->when(

        $this->endDate,

        function($query){

            $query->whereDate(
                'created_at',
                '<=',
                $this->endDate
            );

        }

    )

    ->get();

        $totalProject = $project->count();




        $aktif = $project
            ->where(
                'progres_keseluruhan',
                '<',
                100
            )
            ->count();





        $selesai = $project
            ->where(
                'progres_keseluruhan',
                '>=',
                100
            )
            ->count();





        $progress = $project
            ->avg(
                'progres_keseluruhan'
            ) ?? 0;





        $client = $project
            ->pluck(
                'pemilik_proyek'
            )
            ->unique()
            ->count();





$totalSetoran = SetoranProyek::when(

    $this->startDate,

    function($query){

        $query->whereDate(
            'created_at',
            '>=',
            $this->startDate
        );

    }

)

->when(

    $this->endDate,

    function($query){

        $query->whereDate(
            'created_at',
            '<=',
            $this->endDate
        );

    }

)

->count();





$totalDana = TransaksiDana::when(

    $this->startDate,

    function($query){

        $query->whereDate(
            'created_at',
            '>=',
            $this->startDate
        );

    }

)

->when(

    $this->endDate,

    function($query){

        $query->whereDate(
            'created_at',
            '<=',
            $this->endDate
        );

    }

)

->count();





$transaksi = 
    $totalSetoran 
    +
    $totalDana;




        $totalAnggaran = $project
            ->sum(
                'total_anggaran'
            );





$terbaru = $project
    ->sortByDesc('id')
    ->first();





        $tertinggi = $project
            ->sortByDesc(
                'progres_keseluruhan'
            )
            ->first();





        $terendah = $project
            ->sortBy(
                'progres_keseluruhan'
            )
            ->first();





        $monitoring = $project
            ->where(
                'progres_keseluruhan',
                '<',
                50
            )
            ->count();





        return [

            [

                '',

                '',

                '',

                ''

            ],

            [
                'INFORMASI PERUSAHAAN',
                '',
                '',
                ''
            ],




            [
                'Nama Perusahaan',
                'CV Sahabat Eksplorasi Banua',
                'Status Sistem',
                'Aktif'
            ],




            [
                'Bidang Usaha',
                'Konsultasi & Jasa Pertambangan',
                'Periode Laporan',
                date('Y')
            ],




            [
                'Sistem',
                'Financial Management System',
                'Tanggal Cetak',
                now()->format('d M Y')
            ],




            [
                'STATISTIK OPERASIONAL',
                '',
                '',
                ''
            ],




            [
                'Total Project',
                $totalProject.' Project',
                'Jumlah Client',
                $client.' Client'
            ],




            [
                'Project Aktif',
                $aktif.' Project',
                'Project Selesai',
                $selesai.' Project'
            ],




            [
                'Rata-rata Progress',
                number_format(
                    $progress,
                    1
                ).'%',
                'Total Transaksi',
                $transaksi.' Transaksi'
            ],




            [
                'Project Progress Rendah',
                $monitoring.' Project',
                'Status Operasional',
                $monitoring > 0
                ?
                'Perlu Evaluasi'
                :
                'Aman'
            ],





            [
                'MONITORING PROJECT',
                '',
                '',
                ''
            ],




            [
                'Project Terbaru',
                $terbaru->nama_proyek ?? '-',
                'Progress Tertinggi',
                ($tertinggi->nama_proyek ?? '-')
                .' ('.
                ($tertinggi->progres_keseluruhan ?? 0)
                .'%)'
            ],




            [
                'Progress Terendah',
                ($terendah->nama_proyek ?? '-')
                .' ('.
                ($terendah->progres_keseluruhan ?? 0)
                .'%)',
                'Project Monitoring',
                $monitoring.' Project'
            ],





            [
                'INFORMASI KEUANGAN PROJECT',
                '',
                '',
                ''
            ],





            [
                'Total Nilai Project',
                $totalAnggaran,

                
                'Status Monitoring',
                $monitoring > 0
                ?
                'Perlu Evaluasi'
                :
                'Aman'
            ],





            [
                'INFORMASI LAPORAN',
                '',
                '',
                ''
            ],





            [
                'Modul Laporan',

                'Dashboard, Keuangan, Transaksi, Monitoring Project',

                '',

                ''
            ],



        ];

    }









    public function drawings()
    {


        $drawing = new Drawing();



        $drawing->setName(
            'Logo CV'
        );



        $drawing->setDescription(
            'Logo CV Sahabat Eksplorasi Banua'
        );



        $drawing->setPath(
            public_path(
                'images/logo-cv.png'
            )
        );



        $drawing->setHeight(
            70
        );



        $drawing->setCoordinates(
            'A1'
        );



        $drawing->setOffsetX(
            10
        );



        $drawing->setOffsetY(
            5
        );



        return $drawing;

    }









    public function registerEvents(): array
    {


        return [



            AfterSheet::class => function(AfterSheet $event){


                $sheet = $event
                    ->sheet
                    ->getDelegate();








                /*
                HEADER
                */


                $sheet->mergeCells('B1:E1');

                $sheet->mergeCells('B2:E2');

                $sheet->mergeCells('B3:E3');




                $sheet->setCellValue(
                    'B1',
                    'CV SAHABAT EKSPLORASI BANUA'
                );



                $sheet->setCellValue(
                    'B2',
                    'EXECUTIVE REPORT DASHBOARD'
                );



                $sheet->setCellValue(
                    'B3',
                    'Laporan Monitoring Project dan Informasi Operasional'
                );






                $sheet->getStyle(
                    'B1:E3'
                )
                ->applyFromArray([



                    'font'=>[

                        'bold'=>true

                    ],



                    'alignment'=>[

                        'horizontal'=>Alignment::HORIZONTAL_CENTER,

                        'vertical'=>Alignment::VERTICAL_CENTER

                    ]



                ]);



                $sheet->getStyle('B1')
                    ->getFont()
                    ->setSize(16);



                $sheet->getStyle('B2')
                    ->getFont()
                    ->setSize(13);



                $sheet->getStyle('B3')
                    ->getFont()
                    ->setItalic(true)
                    ->setSize(10);









                /*
                SECTION
                */

                $sectionRows = [

                    6,

                    11,

                    16,

                    19
                ];





                foreach($sectionRows as $row){


                    $sheet->mergeCells(
                        'A'.$row.':D'.$row
                    );



                    $sheet->getStyle(
                        'A'.$row.':D'.$row
                    )
                    ->applyFromArray([



                        'fill'=>[

                            'fillType'=>Fill::FILL_SOLID,

                            'startColor'=>[
                                'rgb'=>'000000'
                            ]

                        ],



                        'font'=>[

                            'bold'=>true,

                            'color'=>[
                                'rgb'=>'FFFFFF'
                            ]

                        ],



                        'alignment'=>[

                            'horizontal'=>Alignment::HORIZONTAL_CENTER

                        ]



                    ]);


                }









                /*
                BORDER
                */


                $lastRow = $sheet->getHighestRow();



                $sheet->getStyle(
                    'A6:D'.$lastRow
                )
                ->applyFromArray([



                    'borders'=>[

                        'allBorders'=>[

                            'borderStyle'=>Border::BORDER_THIN,

                            'color'=>[
                                'rgb'=>'D1D5DB'
                            ]

                        ]

                    ]



                ]);





                $sheet->getStyle(
                    'A6:D'.$lastRow
                )
                ->getAlignment()
                ->setVertical(
                    Alignment::VERTICAL_CENTER
                );


$sheet->getStyle(
    'B12:B19'
)
->getAlignment()
->setHorizontal(
    Alignment::HORIZONTAL_RIGHT
);
                /*
                LABEL
                */


                foreach(['A','C'] as $col){


                    $sheet->getStyle(
                        $col.'7:'.$col.$lastRow
                    )
                    ->getFont()
                    ->setBold(true);


                }









                /*
                STATUS WARNA
                */


                $sheet->getStyle('D7')
                ->applyFromArray([


                    'fill'=>[

                        'fillType'=>Fill::FILL_SOLID,

                        'startColor'=>[
                            'rgb'=>'DCFCE7'
                        ]

                    ],


                    'font'=>[

                        'bold'=>true,

                        'color'=>[
                            'rgb'=>'15803D'
                        ]

                    ]

                ]);





                $sheet->getStyle('D14')
                ->applyFromArray([


                    'fill'=>[

                        'fillType'=>Fill::FILL_SOLID,

                        'startColor'=>[
                            'rgb'=>'FEF3C7'
                        ]

                    ],


                    'font'=>[

                        'bold'=>true

                    ]

                ]);









                /*
                RUPIAH
                */


                $sheet->getStyle(
                    'B19'
                )
                ->getNumberFormat()
                ->setFormatCode(
                    '"Rp" #,##0'
                );


/*
HIGHLIGHT TOTAL PROJECT VALUE
*/


$sheet->getStyle(
    'B19'
)
->applyFromArray([


    'fill'=>[

        'fillType'=>Fill::FILL_SOLID,

        'startColor'=>[

            'rgb'=>'DCFCE7'

        ]

    ],


    'font'=>[

        'bold'=>true

    ]

]);



                /*
                WIDTH
                */


                $sheet->getColumnDimension('A')
                    ->setWidth(30);


                $sheet->getColumnDimension('B')
                    ->setWidth(45);


                $sheet->getColumnDimension('C')
                    ->setWidth(30);


                $sheet->getColumnDimension('D')
                    ->setWidth(25);









                /*
                HEIGHT
                */


                $sheet->getRowDimension(1)
                    ->setRowHeight(45);



                $sheet->getRowDimension(2)
                    ->setRowHeight(30);



                $sheet->getRowDimension(3)
                    ->setRowHeight(20);





                foreach($sectionRows as $row){

                    $sheet->getRowDimension($row)
                        ->setRowHeight(25);

                }


$sheet->mergeCells(
    'B21:D21'
);






                $sheet->freezePane(
                    'A7'
                );


            }


        ];

    }


}