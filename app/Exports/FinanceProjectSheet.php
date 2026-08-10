<?php

namespace App\Exports;


use App\Models\Proyek;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;


use Maatwebsite\Excel\Events\AfterSheet;


use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;



class FinanceProjectSheet implements

    FromCollection,

    WithHeadings,

    WithMapping,

    WithEvents,

    WithDrawings,

    WithColumnWidths,

    WithTitle,

    WithCustomStartCell

{


    public function title(): string
    {
        return 'Monitoring Project';
    }



    public function startCell(): string
    {
        return 'A6';
    }





    public function collection()
    {
        return Proyek::latest()->get();
    }





    public function headings(): array
    {

        return [

            'Nama Project',

            'Pemilik Project',

            'Tanggal Mulai',

            'Tanggal Selesai',

            'Anggaran',

            'Progress',

            'Status'

        ];

    }





    public function map($project): array
    {

        $progress = $project->progres_keseluruhan ?? 0;


        return [

            $project->nama_proyek ?? '-',

            $project->pemilik_proyek ?? '-',


            $project->tanggal_mulai
            ? date(
                'd M Y',
                strtotime($project->tanggal_mulai)
            )
            : '-',



            $project->tanggal_selesai
            ? date(
                'd M Y',
                strtotime($project->tanggal_selesai)
            )
            : '-',



            $project->total_anggaran ?? 0,


            $progress,


            $progress >= 100

            ? 'Selesai'

            : (

                $progress > 0

                ? 'Berjalan'

                : 'Belum Dimulai'

            )


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
            60
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


                $sheet->mergeCells(
                    'B1:G1'
                );


                $sheet->mergeCells(
                    'B2:G2'
                );



                $sheet->setCellValue(
                    'B1',
                    'CV SAHABAT EKSPLORASI BANUA'
                );


                $sheet->setCellValue(
                    'B2',
                    'LAPORAN MONITORING PROJECT'
                );



                $sheet->getStyle(
                    'B1:G2'
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
                HEADER TABLE
                */


                $sheet->getStyle(
                    'A6:G6'
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






                $lastRow = $sheet->getHighestRow();





                /*
                BORDER
                */


                $sheet->getStyle(
                    'A6:G'.$lastRow
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
                FORMAT
                */


                $sheet->getStyle(
                    'E7:E'.$lastRow
                )
                ->getNumberFormat()
                ->setFormatCode(

                    '"Rp" #,##0'

                );




                $sheet->getStyle(
                    'A7:G'.$lastRow
                )
                ->getAlignment()
                ->setVertical(
                    Alignment::VERTICAL_CENTER
                );



                $sheet->getStyle(
                    'C7:G'.$lastRow
                )
                ->getAlignment()
                ->setHorizontal(
                    Alignment::HORIZONTAL_CENTER
                );







                /*
                PROGRESS
                */


                for(
                    $i=7;
                    $i <= $lastRow;
                    $i++
                ){

                    $value = $sheet
                        ->getCell('F'.$i)
                        ->getValue();


                    $sheet->setCellValue(

                        'F'.$i,

                        is_numeric($value)

                        ? $value.'%'

                        : '0%'

                    );

                }








                /*
                STATUS COLOR
                */


                for(
                    $i=7;
                    $i <= $lastRow;
                    $i++
                ){


                    $status = $sheet
                        ->getCell('G'.$i)
                        ->getValue();



                    if($status == 'Selesai'){


                        $sheet->getStyle(
                            'G'.$i
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
                    elseif($status == 'Berjalan'){


                        $sheet->getStyle(
                            'G'.$i
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
                    else{


                        $sheet->getStyle(
                            'G'.$i
                        )
                        ->applyFromArray([


                            'fill'=>[

                                'fillType'=>Fill::FILL_SOLID,

                                'startColor'=>[

                                    'rgb'=>'FEF3C7'

                                ]

                            ],


                            'font'=>[

                                'bold'=>true,

                                'color'=>[

                                    'rgb'=>'92400E'

                                ]

                            ]


                        ]);

                    }


                }






                /*
                TOTAL ANGGARAN
                */


                $totalBudget = Proyek::sum(
                    'total_anggaran'
                );


                $row = $lastRow + 2;



                $sheet->setCellValue(
                    'D'.$row,
                    'TOTAL ANGGARAN'
                );


                $sheet->setCellValue(
                    'E'.$row,
                    $totalBudget
                );



                $sheet->getStyle(
                    'D'.$row.':E'.$row
                )
                ->applyFromArray([


                    'font'=>[

                        'bold'=>true

                    ],


                    'fill'=>[

                        'fillType'=>Fill::FILL_SOLID,

                        'startColor'=>[

                            'rgb'=>'FEF3C7'

                        ]

                    ],


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
                    'E'.$row
                )
                ->getNumberFormat()
                ->setFormatCode(
                    '"Rp" #,##0'
                );







                /*
                COLUMN
                */


                $sheet->getColumnDimension('A')
                    ->setWidth(30);


                $sheet->getColumnDimension('B')
                    ->setWidth(25);


                $sheet->getColumnDimension('C')
                    ->setWidth(18);


                $sheet->getColumnDimension('D')
                    ->setWidth(18);


                $sheet->getColumnDimension('E')
                    ->setWidth(20);


                $sheet->getColumnDimension('F')
                    ->setWidth(15);


                $sheet->getColumnDimension('G')
                    ->setWidth(15);






                $sheet->getRowDimension(1)
                    ->setRowHeight(45);


                $sheet->getRowDimension(2)
                    ->setRowHeight(30);


                $sheet->getRowDimension(6)
                    ->setRowHeight(25);






                $sheet->setAutoFilter(
                    'A6:G'.$lastRow
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

            'A'=>30,

            'B'=>25,

            'C'=>18,

            'D'=>18,

            'E'=>20,

            'F'=>15,

            'G'=>15

        ];

    }


}