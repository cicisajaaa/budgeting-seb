<?php

namespace App\Exports;


use App\Models\Proyek;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithColumnWidths;


use Maatwebsite\Excel\Events\AfterSheet;


use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;



class ProjectReportExport implements

    FromCollection,

    WithHeadings,

    WithMapping,

    WithEvents,

    WithDrawings,

    WithCustomStartCell,

    WithColumnWidths

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






    private function getProjects()
    {

        return Proyek::when(

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

    }







    public function startCell(): string
    {

        return 'A6';

    }







    public function collection()
    {

        return $this->getProjects();

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









    public function map($project): array
    {

        return [

            $project->nama_proyek ?? '-',

            $project->pemilik_proyek ?? '-',

            $project->total_anggaran ?? 0,

            $project->progres_keseluruhan ?? 0,

            $project->tanggal_selesai
            ?
            date(
                'd M Y',
                strtotime(
                    $project->tanggal_selesai
                )
            )
            :
            '-'

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





                $sheet->mergeCells(
                    'B1:E1'
                );


                $sheet->mergeCells(
                    'B2:E2'
                );



                $sheet->setCellValue(
                    'B1',
                    'CV SAHABAT EKSPLORASI BANUA'
                );



                $sheet->setCellValue(
                    'B2',
                    'LAPORAN PROJECT PERUSAHAAN'
                );





                $sheet->getStyle(
                    'B1:E2'
                )
                ->applyFromArray([


                    'font'=>[

                        'bold'=>true,

                        'size'=>16

                    ],


                    'alignment'=>[

                        'horizontal'=>Alignment::HORIZONTAL_CENTER,

                        'vertical'=>Alignment::VERTICAL_CENTER

                    ]

                ]);






                $sheet->getStyle(
                    'A6:E6'
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

                        'horizontal'=>Alignment::HORIZONTAL_CENTER

                    ]

                ]);





                $lastRow = $sheet->getHighestRow();





                $sheet->getStyle(
                    'A6:E'.$lastRow
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
                    'C7:C'.$lastRow
                )
                ->getNumberFormat()
                ->setFormatCode(
                    '"Rp" #,##0'
                );

                                /*
                CENTER DATA
                */

                $sheet->getStyle(
                    'C7:E'.$lastRow
                )
                ->getAlignment()
                ->setHorizontal(
                    Alignment::HORIZONTAL_CENTER
                );







                /*
                PROGRESS STYLE
                */


                for(
                    $i = 7;
                    $i <= $lastRow;
                    $i++
                ){

                    $progress = (int)$sheet
                        ->getCell(
                            'D'.$i
                        )
                        ->getValue();



                    $sheet->setCellValue(
                        'D'.$i,
                        $progress.'%'
                    );



                    if($progress >= 100){


                        $sheet->getStyle(
                            'D'.$i
                        )
                        ->applyFromArray([


                            'fill'=>[

                                'fillType'=>Fill::FILL_SOLID,

                                'startColor'=>[
                                    'rgb'=>'DBEAFE'
                                ]

                            ],


                            'font'=>[

                                'bold'=>true,

                                'color'=>[
                                    'rgb'=>'1D4ED8'
                                ]

                            ]

                        ]);


                    }
                    else{


                        $sheet->getStyle(
                            'D'.$i
                        )
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

                    }


                }









                /*
                SUMMARY PROJECT
                */


                $row = $lastRow + 3;



                $sheet->mergeCells(
                    'C'.$row.':E'.$row
                );



                $sheet->setCellValue(
                    'C'.$row,
                    'RINGKASAN PROJECT'
                );



                $sheet->getStyle(
                    'C'.$row.':E'.$row
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

                        'horizontal'=>Alignment::HORIZONTAL_CENTER

                    ]

                ]);






                /*
                FILTER SUMMARY
                */


                $projects = $this->getProjects();



                $totalProject = $projects->count();



                $totalBudget = $projects->sum(
                    'total_anggaran'
                );





                $sheet->setCellValue(
                    'C'.($row+1),
                    'Total Project'
                );



                $sheet->setCellValue(
                    'D'.($row+1),
                    $totalProject.' Project'
                );





                $sheet->setCellValue(
                    'C'.($row+2),
                    'Total Anggaran'
                );



                $sheet->setCellValue(
                    'D'.($row+2),
                    $totalBudget
                );






                $sheet->getStyle(
                    'C'.($row+1).':D'.($row+2)
                )
                ->applyFromArray([


                    'borders'=>[

                        'allBorders'=>[

                            'borderStyle'=>Border::BORDER_THIN,

                            'color'=>[
                                'rgb'=>'D1D5DB'
                            ]

                        ]

                    ],


                    'font'=>[

                        'bold'=>true

                    ]

                ]);






                $sheet->getStyle(
                    'D'.($row+2)
                )
                ->getNumberFormat()
                ->setFormatCode(
                    '"Rp" #,##0'
                );









                /*
                COLUMN SIZE
                */


                $sheet->getColumnDimension('A')
                    ->setWidth(32);



                $sheet->getColumnDimension('B')
                    ->setWidth(25);



                $sheet->getColumnDimension('C')
                    ->setWidth(22);



                $sheet->getColumnDimension('D')
                    ->setWidth(18);



                $sheet->getColumnDimension('E')
                    ->setWidth(20);









                /*
                ROW SIZE
                */


                $sheet->getRowDimension(1)
                    ->setRowHeight(45);



                $sheet->getRowDimension(2)
                    ->setRowHeight(30);



                $sheet->getRowDimension(6)
                    ->setRowHeight(25);









                /*
                FILTER + FREEZE
                */


                $sheet->setAutoFilter(
                    'A6:E'.$lastRow
                );



                $sheet->freezePane(
                    'A7'
                );


            }


        ];

    }









    public function columnWidths(): array
    {

        return [

            'A'=>32,

            'B'=>25,

            'C'=>22,

            'D'=>18,

            'E'=>20

        ];

    }


}