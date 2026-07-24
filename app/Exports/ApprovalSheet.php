<?php

namespace App\Exports;


use App\Models\PengajuanDana;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;


use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;



class ApprovalSheet implements
FromCollection,
WithTitle,
WithStyles,
WithColumnWidths
{


    public function collection()
    {


        $data = PengajuanDana::with([

            'proyek',

            'divisi',

            'pengguna'

        ])

        ->latest()

        ->get()

        ->map(function($request){


            return [



                'Tanggal' =>

                date(

                    'd M Y',

                    strtotime(

                        $request->created_at

                    )

                ),





                'Pemohon' =>

                $request->pengguna->name ?? '-',






                'Project' =>

                $request->proyek->nama_proyek ?? '-',






                'Divisi' =>

                $request->divisi->nama_divisi ?? '-',






                'Judul Pengajuan' =>

                $request->judul ?? '-',






                'Nominal' =>

                $request->jumlah,








                'Status' =>

                ucfirst(

                    $request->status

                )


            ];


        });








        /*
        |--------------------------------------------------------------------------
        | TOTAL PENGAJUAN
        |--------------------------------------------------------------------------
        */


        $data->push([


            'Tanggal'=>'',


            'Pemohon'=>'',


            'Project'=>'',


            'Divisi'=>'',


            'Judul Pengajuan'=>'TOTAL PENGAJUAN',


            'Nominal'=>$data->sum('Nominal'),


            'Status'=>'Total'


        ]);



        return $data;


    }









    public function headings():array
    {


        return [

            'Tanggal',

            'Pemohon',

            'Project',

            'Divisi',

            'Judul Pengajuan',

            'Nominal',

            'Status'


        ];

    }










    public function title():string
    {

        return 'Approval Dana';

    }










    public function styles(Worksheet $sheet)
    {



        /*
        |--------------------------------------------------------------------------
        | HEADER LAPORAN
        |--------------------------------------------------------------------------
        */


        $sheet->insertNewRowBefore(1,4);




        $sheet->mergeCells(

            'A1:G1'

        );


        $sheet->mergeCells(

            'A2:G2'

        );



        $sheet->mergeCells(

            'A3:B3'

        );


        $sheet->mergeCells(

            'D3:G3'

        );






        $sheet->setCellValue(

            'A1',

            'CV SAHABAT ALAM'

        );




        $sheet->setCellValue(

            'A2',

            'LAPORAN APPROVAL PENGAJUAN DANA'

        );




        $sheet->setCellValue(

            'A3',

            'Report No : FIN-'.date('Y').'-001'

        );



        $sheet->setCellValue(

            'D3',

            'Periode : '.date('F Y')

        );








        $sheet->getStyle(

            'A1:G3'

        )

        ->getFont()

        ->setBold(true);



        $sheet->getStyle(

            'A1:G2'

        )

        ->getFont()

        ->setSize(16);



        $sheet->getStyle(

            'A1:G3'

        )

        ->getAlignment()

        ->setHorizontal(

            'center'

        );









        /*
        |--------------------------------------------------------------------------
        | TABLE HEADER
        |--------------------------------------------------------------------------
        */


        $sheet->getStyle(

            'A5:G5'

        )

        ->getFill()

        ->setFillType(

            Fill::FILL_SOLID

        )

        ->getStartColor()

        ->setARGB(

            '166534'

        );




        $sheet->getStyle(

            'A5:G5'

        )

        ->getFont()

        ->setBold(true)

        ->getColor()

        ->setARGB(

            'FFFFFF'

        );









        /*
        |--------------------------------------------------------------------------
        | FORMAT NOMINAL
        |--------------------------------------------------------------------------
        */


        $lastRow = $sheet->getHighestRow();



        $sheet->getStyle(

            "F6:F$lastRow"

        )

        ->getNumberFormat()

        ->setFormatCode(

            '"Rp" #,##0'

        );









        /*
        |--------------------------------------------------------------------------
        | STATUS COLOR
        |--------------------------------------------------------------------------
        */


        for($i=6;$i<$lastRow;$i++)

        {


            $status = strtolower(

                $sheet->getCell(

                    "G$i"

                )->getValue()

            );



            if($status=="approved")
            {

                $color='DCFCE7';

            }
            elseif($status=="pending")
            {

                $color='FEF3C7';

            }
            else
            {

                $color='FEE2E2';

            }



            $sheet->getStyle(

                "G$i"

            )

            ->getFill()

            ->setFillType(

                Fill::FILL_SOLID

            )

            ->getStartColor()

            ->setARGB(

                $color

            );


        }










        /*
        |--------------------------------------------------------------------------
        | TOTAL ROW
        |--------------------------------------------------------------------------
        */


        $sheet->getStyle(

            "A$lastRow:G$lastRow"

        )

        ->getFill()

        ->setFillType(

            Fill::FILL_SOLID

        )

        ->getStartColor()

        ->setARGB(

            'DCFCE7'

        );



        $sheet->getStyle(

            "A$lastRow:G$lastRow"

        )

        ->getFont()

        ->setBold(true);










        /*
        |--------------------------------------------------------------------------
        | BORDER
        |--------------------------------------------------------------------------
        */


        $sheet->getStyle(

            "A5:G$lastRow"

        )

        ->getBorders()

        ->getAllBorders()

        ->setBorderStyle(

            Border::BORDER_THIN

        );









        /*
        |--------------------------------------------------------------------------
        | LOGO
        |--------------------------------------------------------------------------
        */


        $logo = public_path(

            'images/logo-cv.png'

        );



        if(file_exists($logo))
        {


            $drawing = new Drawing();


            $drawing->setName(

                'Logo'

            );


            $drawing->setPath(

                $logo

            );


            $drawing->setHeight(

                45

            );


            $drawing->setCoordinates(

                'A1'

            );


            $drawing->setWorksheet(

                $sheet

            );


        }









        /*
        |--------------------------------------------------------------------------
        | FOOTER
        |--------------------------------------------------------------------------
        */


        $signRow = $lastRow + 4;



        $sheet->setCellValue(

            "A$signRow",

            "Mengetahui,"

        );



        $sheet->setCellValue(

            "E$signRow",

            "Keuangan,"

        );



        $sheet->setCellValue(

            "A".($signRow+3),

            "(........................)"

        );



        $sheet->setCellValue(

            "E".($signRow+3),

            "(........................)"

        );









        /*
        |--------------------------------------------------------------------------
        | FILTER + FREEZE
        |--------------------------------------------------------------------------
        */


        $sheet->freezePane(

            'A6'

        );



        $sheet->setAutoFilter(

            "A5:G".($lastRow-1)

        );




        return $sheet;


    }









    public function columnWidths():array
    {


        return [


            'A'=>18,

            'B'=>25,

            'C'=>30,

            'D'=>20,

            'E'=>35,

            'F'=>20,

            'G'=>15,


        ];


    }


}