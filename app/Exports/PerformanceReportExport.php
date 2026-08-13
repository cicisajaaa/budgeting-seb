<?php

namespace App\Exports;


use App\Models\Proyek;


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



class PerformanceReportExport implements

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

        return 'Analisis Performa';

    }





    public function startCell(): string
    {

        return 'A6';

    }








    public function array(): array
    {


     $projects = Proyek::when(

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

->latest()

->get();



        $totalProject = $projects->count();



        $projectAktif = $projects
            ->where(
                'progres_keseluruhan',
                '<',
                100
            )
            ->count();



        $projectSelesai = $projects
            ->where(
                'progres_keseluruhan',
                '>=',
                100
            )
            ->count();



        $projectBelumMulai = $projects
            ->where(
                'progres_keseluruhan',
                0
            )
            ->count();




        $projectHampirSelesai = $projects
            ->whereBetween(
                'progres_keseluruhan',
                [
                    75,
                    99
                ]
            )
            ->count();




        $projectRisiko = $projects
            ->where(
                'progres_keseluruhan',
                '<',
                50
            )
            ->count();




        $progressRata = $projects
            ->avg(
                'progres_keseluruhan'
            ) ?? 0;





        $progressAktif = $projects
            ->where(
                'progres_keseluruhan',
                '<',
                100
            )
            ->avg(
                'progres_keseluruhan'
            ) ?? 0;






        $totalAnggaran = $projects
            ->sum(
                'total_anggaran'
            );





        $anggaranAktif = $projects
            ->where(
                'progres_keseluruhan',
                '<',
                100
            )
            ->sum(
                'total_anggaran'
            );





        $anggaranSelesai = $projects
            ->where(
                'progres_keseluruhan',
                '>=',
                100
            )
            ->sum(
                'total_anggaran'
            );






        $rataAnggaran = $totalProject > 0

            ?

            $totalAnggaran / $totalProject

            :

            0;






        $jumlahClient = $projects
            ->pluck(
                'pemilik_proyek'
            )
            ->unique()
            ->count();







        $budgetTerbesar = $projects
            ->sortByDesc(
                'total_anggaran'
            )
            ->first();






        $budgetTerkecil = $projects
            ->sortBy(
                'total_anggaran'
            )
            ->first();







        $progressTertinggi = $projects
            ->sortByDesc(
                'progres_keseluruhan'
            )
            ->first();







        $progressTerendah = $projects
            ->sortBy(
                'progres_keseluruhan'
            )
            ->first();







        $projectTerbaru = $projects
            ->sortByDesc(
                'created_at'
            )
            ->first();






        $projectTerlama = $projects
            ->sortBy(
                'created_at'
            )
            ->first();







        $persentaseSelesai = $totalProject > 0

            ?

            ($projectSelesai / $totalProject) * 100

            :

            0;







        if($progressRata >= 85){

            $status = 'Sangat Baik';

        }elseif($progressRata >= 70){

            $status = 'Baik';

        }elseif($progressRata >= 50){

            $status = 'Cukup';

        }else{

            $status = 'Perlu Monitoring';

        }









        return [



            /*
            DASHBOARD KPI
            */


            [

                'RINGKASAN UTAMA',

                '',

                '',

                '',

                '',

                '',

                '',

                ''

            ],



            [

                'Total Project',

                $totalProject,

                'Project Aktif',

                $projectAktif,

                'Project Selesai',

                $projectSelesai,

                'Client',

                $jumlahClient

            ],



            [

                'Total Anggaran',

                $totalAnggaran,

                'Rata Progress',

                number_format(
                    $progressRata,
                    1
                ).'%',

                'Penyelesaian',

                number_format(
                    $persentaseSelesai,
                    1
                ).'%',

                'Status',

                $status

            ],






            [
                'ANALISIS OPERASIONAL',

                '',

                '',

                '',

                '',

                '',

                '',

                ''

            ],



            [

                'Project Belum Mulai',

                $projectBelumMulai,

                'Project Hampir Selesai',

                $projectHampirSelesai,

                'Project Risiko',

                $projectRisiko,

                'Progress Aktif',

                number_format(
                    $progressAktif,
                    1
                ).'%'

            ],






            [

                'ANALISIS KEUANGAN',

                '',

                '',

                '',

                '',

                '',

                '',

                ''

            ],



            [

                'Total Nilai Project',

                $totalAnggaran,

                'Nilai Project Aktif',

                $anggaranAktif,

                'Nilai Project Selesai',

                $anggaranSelesai,

                'Rata Anggaran',

                $rataAnggaran

            ],



            [

                'Budget Terbesar',

                $budgetTerbesar->nama_proyek ?? '-',

                'Nilai Terbesar',

                $budgetTerbesar->total_anggaran ?? 0,

                'Budget Terkecil',

                $budgetTerkecil->nama_proyek ?? '-',

                'Nilai Terkecil',

                $budgetTerkecil->total_anggaran ?? 0

            ],







            [

                'ANALISIS PROGRESS',

                '',

                '',

                '',

                '',

                '',

                '',

                ''

            ],



            [

                'Progress Tertinggi',

                $progressTertinggi->nama_proyek ?? '-',

                'Nilai',

                ($progressTertinggi->progres_keseluruhan ?? 0).'%',


                'Progress Terendah',

                $progressTerendah->nama_proyek ?? '-',

                'Nilai',

                ($progressTerendah->progres_keseluruhan ?? 0).'%'

            ],






            [

                'EVALUASI',

                '',

                '',

                '',

                '',

                '',

                '',

                ''

            ],



            [

                'Project Terbaru',

                $projectTerbaru->nama_proyek ?? '-',

                'Project Terlama',

                $projectTerlama->nama_proyek ?? '-',

                'Tanggal Laporan',

                now()->format('d M Y'),

                '',

                ''

            ]



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
                HEADER PERUSAHAAN
                */


                $sheet->mergeCells(
                    'B1:H1'
                );


                $sheet->mergeCells(
                    'B2:H2'
                );



                $sheet->setCellValue(
                    'B1',
                    'CV SAHABAT EKSPLORASI BANUA'
                );



                $sheet->setCellValue(
                    'B2',
                    'ANALISIS PERFORMA PERUSAHAAN'
                );








                $sheet->getStyle(
                    'B1:H2'
                )
                ->applyFromArray([



                    'font'=>[

                        'bold'=>true,

                        'size'=>16,

                        'color'=>[
                            'rgb'=>'000000'
                        ]

                    ],



                    'alignment'=>[

                        'horizontal'=>Alignment::HORIZONTAL_CENTER,

                        'vertical'=>Alignment::VERTICAL_CENTER

                    ]



                ]);








                /*
                SECTION HEADER
                */


                $sectionRows = [


                    6,
                    10,
                    13,
                    17,
                    20


                ];





                foreach($sectionRows as $row){



                    $sheet->mergeCells(
                        'A'.$row.':H'.$row
                    );



                    $sheet->getStyle(
                        'A'.$row.':H'.$row
                    )
                    ->applyFromArray([



                        'font'=>[

                            'bold'=>true,

                            'color'=>[
                                'rgb'=>'FFFFFF'
                            ]

                        ],



                        'fill'=>[

                            'fillType'=>Fill::FILL_SOLID,

                            'startColor'=>[
                                'rgb'=>'000000'
                            ]

                        ],



                        'alignment'=>[

                            'horizontal'=>Alignment::HORIZONTAL_CENTER,

                            'vertical'=>Alignment::VERTICAL_CENTER

                        ]



                    ]);



                }









                /*
                BORDER
                */


                $lastRow = $sheet->getHighestRow();



                $sheet->getStyle(
                    'A6:H'.$lastRow
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









                /*
                KPI STYLE
                */


                foreach([7,8,11,14,15,18,21] as $row){



                    $sheet->getStyle(
                        'A'.$row.':H'.$row
                    )
                    ->applyFromArray([



                        'alignment'=>[

                            'horizontal'=>Alignment::HORIZONTAL_CENTER,

                            'vertical'=>Alignment::VERTICAL_CENTER

                        ]



                    ]);



                }









                /*
                LABEL BOLD
                */


                for(
                    $row = 7;
                    $row <= $lastRow;
                    $row++
                ){



                    foreach([

                        'A',
                        'C',
                        'E',
                        'G'

                    ] as $column){



                        $sheet->getStyle(
                            $column.$row
                        )
                        ->getFont()
                        ->setBold(true);



                    }


                }









                /*
                FORMAT RUPIAH
                */


                for(
                    $row = 7;
                    $row <= $lastRow;
                    $row++
                ){



                    foreach([

                        'B',
                        'D',
                        'F',
                        'H'

                    ] as $column){



                        $value = $sheet
                            ->getCell(
                                $column.$row
                            )
                            ->getValue();



                        if(
                            is_numeric($value)
                        ){



                            if(
                                $value > 1000
                            ){


                                $sheet->getStyle(
                                    $column.$row
                                )
                                ->getNumberFormat()
                                ->setFormatCode(
                                    '"Rp" #,##0'
                                );


                            }



                        }



                    }


                }









                /*
                COLUMN WIDTH
                */


                $sheet->getColumnDimension('A')
                    ->setWidth(25);



                $sheet->getColumnDimension('B')
                    ->setWidth(18);



                $sheet->getColumnDimension('C')
                    ->setWidth(25);



                $sheet->getColumnDimension('D')
                    ->setWidth(18);



                $sheet->getColumnDimension('E')
                    ->setWidth(25);



                $sheet->getColumnDimension('F')
                    ->setWidth(18);



                $sheet->getColumnDimension('G')
                    ->setWidth(25);



                $sheet->getColumnDimension('H')
                    ->setWidth(18);









                /*
                HEIGHT
                */


                $sheet->getRowDimension(1)
                    ->setRowHeight(45);



                $sheet->getRowDimension(2)
                    ->setRowHeight(30);



                foreach($sectionRows as $row){


                    $sheet->getRowDimension($row)
                        ->setRowHeight(25);


                }









                /*
                FREEZE
                */


                $sheet->freezePane(
                    'A7'
                );



            }


        ];


    }
}