<?php

namespace App\Exports;


use App\Models\ProjectDeposit;
use App\Models\ExpenseRequest;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithDrawings;


use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;




class OwnerReportExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithColumnWidths,
    WithDrawings
{





    /*
    |--------------------------------------------------------------------------
    | DATA TRANSAKSI
    |--------------------------------------------------------------------------
    */


    public function collection()
    {


        $pemasukan = ProjectDeposit::with('proyek')
            ->latest()
            ->get();



        $pengeluaran = ExpenseRequest::with('proyek')
            ->where(
                'status',
                'approved'
            )
            ->latest()
            ->get();



        return $pemasukan->concat(
            $pengeluaran
        );


    }









    /*
    |--------------------------------------------------------------------------
    | HEADER TABEL
    |--------------------------------------------------------------------------
    */


    public function headings(): array
    {


        return [

            'Tanggal',

            'Jenis Transaksi',

            'Project',

            'Keterangan',

            'Nominal'


        ];


    }









    /*
    |--------------------------------------------------------------------------
    | FORMAT DATA
    |--------------------------------------------------------------------------
    */


    public function map($row): array
    {



        if(isset($row->jumlah_setoran))
        {


            return [


                $row->created_at
                ? $row->created_at->format('d M Y')
                : '-',



                'Pemasukan',



                $row->proyek->nama_proyek ?? '-',



                'Setoran Proyek',



                $row->jumlah_setoran


            ];

        }





        return [


            $row->created_at
            ? $row->created_at->format('d M Y')
            : '-',



            'Pengeluaran',



            $row->proyek->nama_proyek ?? '-',



            $row->judul ?? 'Pengajuan Dana',



            $row->jumlah ?? 0


        ];



    }









    /*
    |--------------------------------------------------------------------------
    | LOGO PERUSAHAAN
    |--------------------------------------------------------------------------
    */


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









    /*
    |--------------------------------------------------------------------------
    | STYLE EXCEL
    |--------------------------------------------------------------------------
    */


    public function styles(Worksheet $sheet)
    {


        /*
        HEADER PERUSAHAAN
        */


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
            'LAPORAN KEUANGAN PERUSAHAAN'
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

                'horizontal'=>'center',

                'vertical'=>'center'

            ]


        ]);







        /*
        HEADER TABLE
        */


        $sheet->getStyle(
            'A4:E4'
        )
        ->applyFromArray([


            'font'=>[

                'bold'=>true,

                'color'=>[

                    'FFFFFF'

                ]

            ],



            'fill'=>[


                'fillType'=>'solid',


                'color'=>[

                    '8B5E22'

                ]


            ],



            'alignment'=>[

                'horizontal'=>'center'

            ]


        ]);









        /*
        BORDER DATA
        */


        $sheet->getStyle(
            'A5:E500'
        )
        ->applyFromArray([


            'borders'=>[


                'allBorders'=>[


                    'borderStyle'=>'thin',


                    'color'=>[

                        'D1D5DB'

                    ]


                ]

            ]


        ]);









        /*
        FORMAT RUPIAH
        */


        $sheet->getStyle(
            'E5:E500'
        )
        ->getNumberFormat()
        ->setFormatCode(

            '"Rp" #,##0'

        );








        /*
        TINGGI BARIS HEADER
        */


        $sheet->getRowDimension(1)
            ->setRowHeight(40);



        $sheet->getRowDimension(2)
            ->setRowHeight(30);






        /*
        FREEZE HEADER
        */


        $sheet->freezePane(
            'A5'
        );




        return $sheet;


    }









    /*
    |--------------------------------------------------------------------------
    | UKURAN KOLOM
    |--------------------------------------------------------------------------
    */


    public function columnWidths(): array
    {


        return [


            'A'=>18,


            'B'=>22,


            'C'=>35,


            'D'=>35,


            'E'=>20


        ];


    }


}