<?php

namespace App\Exports;


use App\Models\PengajuanDana;


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



class ApprovalSheet implements

    FromArray,

    WithEvents,

    WithDrawings,

    WithTitle,

    WithCustomStartCell

{


    public function title(): string
    {
        return 'Approval Dana';
    }







    public function startCell(): string
    {
        return 'A6';
    }









    public function array(): array
    {


        $requests = PengajuanDana::with([

            'pengguna',
            'proyek',
            'divisi',
            'penyetuju'

        ])

        ->whereIn(

            'status',

            [

                'approved',

                'rejected'

            ]

        )

        ->latest()

        ->get();






        $rows = [



            [

                '',

                '',

                '',

                '',

                '',

                '',

                '',

                ''

            ],





            [

                'INFORMASI APPROVAL DANA',

                '',

                '',

                '',

                '',

                '',

                '',

                ''

            ],





            [

                'Sistem',

                'Financial Management System',

                'Tanggal Cetak',

                now()->format('d M Y'),

                '',

                '',

                '',

                ''

            ],





            [

                'Status Laporan',

                'Approved & Rejected',

                '',

                '',

                '',

                '',

                '',

                ''

            ],





            [

                'TOTAL DATA APPROVAL',

                '',

                '',

                '',

                '',

                '',

                '',

                ''

            ],





            [

                'Tanggal',

                'Pemohon',

                'Project',

                'Divisi',

                'Nominal',

                'Status',

                'Disetujui Oleh',

                'Catatan'

            ],



        ];









        foreach($requests as $item)
        {


            $rows[] = [



                optional($item->created_at)

                ->format('d M Y'),




                $item->pengguna->name ?? '-',




                $item->proyek->nama_proyek ?? '-',




                $item->divisi->nama_divisi ?? '-',




                $item->jumlah ?? 0,




                ucfirst(
                    $item->status
                ),




                $item->penyetuju->name ?? '-',




                $item->catatan_persetujuan ?? '-'


            ];



        }








        return $rows;


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


                $sheet->mergeCells(
                    'B3:H3'
                );





                $sheet->setCellValue(
                    'B1',
                    'CV SAHABAT EKSPLORASI BANUA'
                );



                $sheet->setCellValue(
                    'B2',
                    'FINANCIAL MANAGEMENT SYSTEM'
                );



                $sheet->setCellValue(
                    'B3',
                    'LAPORAN APPROVAL DANA'
                );








                $sheet->getStyle(
                    'B1:H3'
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
                SECTION HEADER
                */


                $sectionRows = [


                    7,

                    10


                ];





                foreach($sectionRows as $row){


                    $sheet->mergeCells(
                        'A'.$row.':H'.$row
                    );



                    $sheet->getStyle(
                        'A'.$row.':H'.$row
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
                TABLE HEADER
                */


                $sheet->getStyle(
                    'A11:H11'
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

                        'horizontal'=>Alignment::HORIZONTAL_CENTER,

                        'vertical'=>Alignment::VERTICAL_CENTER

                    ]



                ]);









                /*
                BORDER
                */


                $lastRow = $sheet->getHighestRow();



                $sheet->getStyle(
                    'A7:H'.$lastRow
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
                ALIGNMENT
                */


                $sheet->getStyle(
                    'A7:H'.$lastRow
                )
                ->getAlignment()
                ->setVertical(
                    Alignment::VERTICAL_CENTER
                );





                $sheet->getStyle(
                    'E12:E'.$lastRow
                )
                ->getAlignment()
                ->setHorizontal(
                    Alignment::HORIZONTAL_RIGHT
                );









                /*
                LABEL BOLD
                */


                foreach([

                    'A',
                    'C',
                    'E',
                    'G'

                ] as $column){


                    $sheet->getStyle(
                        $column.'8:'.$column.$lastRow
                    )
                    ->getFont()
                    ->setBold(true);


                }









                /*
                FORMAT RUPIAH
                */


                $sheet->getStyle(
                    'E12:E'.$lastRow
                )
                ->getNumberFormat()
                ->setFormatCode(
                    '"Rp" #,##0'
                );









                /*
                STATUS COLOR
                */


                for(
                    $i = 12;
                    $i <= $lastRow;
                    $i++
                ){



                    $status = $sheet
                    ->getCell(
                        'F'.$i
                    )
                    ->getValue();




                    if($status == 'Approved'){


                        $sheet->getStyle(
                            'F'.$i
                        )
                        ->applyFromArray([


                            'font'=>[

                                'bold'=>true,

                                'color'=>[
                                    'rgb'=>'15803D'
                                ]

                            ]

                        ]);


                    }






                    if($status == 'Rejected'){


                        $sheet->getStyle(
                            'F'.$i
                        )
                        ->applyFromArray([


                            'font'=>[

                                'bold'=>true,

                                'color'=>[
                                    'rgb'=>'DC2626'
                                ]

                            ]

                        ]);


                    }


                }









                /*
                WIDTH
                */


                $sheet->getColumnDimension('A')
                ->setWidth(18);



                $sheet->getColumnDimension('B')
                ->setWidth(25);



                $sheet->getColumnDimension('C')
                ->setWidth(30);



                $sheet->getColumnDimension('D')
                ->setWidth(18);



                $sheet->getColumnDimension('E')
                ->setWidth(18);



                $sheet->getColumnDimension('F')
                ->setWidth(15);



                $sheet->getColumnDimension('G')
                ->setWidth(25);



                $sheet->getColumnDimension('H')
                ->setWidth(35);









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



                $sheet->getRowDimension(11)
                ->setRowHeight(25);









                /*
                FREEZE
                */


                $sheet->freezePane(
                    'A12'
                );



            }


        ];


    }


}