<?php

namespace App\Exports;


use App\Models\ProjectDeposit;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;


use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;



class IncomeSheet implements
FromCollection,
WithTitle,
WithStyles,
WithColumnWidths
{


    public function collection()
    {


        $data = ProjectDeposit::with([

            'project',

            'bank'

        ])
        ->latest()
        ->get()
        ->map(function($deposit){


            return [

                'Tanggal' => date(

                    'd M Y',

                    strtotime(
                        $deposit->tanggal_setoran
                    )

                ),


                'Project' =>

                    $deposit->project->nama_project ?? '-',



                'Bank' =>

                    $deposit->bank->nama_bank ?? '-',



                'Nominal' =>

                    $deposit->jumlah_setoran,



                'Keterangan' =>

                    'Pembayaran Project'


            ];


        });





        /*
        |--------------------------------------------------------------------------
        | Total Dana Masuk
        |--------------------------------------------------------------------------
        */


        $data->push([


            'Tanggal'=>'',


            'Project'=>'TOTAL DANA MASUK',


            'Bank'=>'',


            'Nominal'=>$data->sum('Nominal'),


            'Keterangan'=>'Total Pemasukan'


        ]);






        return $data;


    }









    public function title(): string
    {

        return 'Dana Masuk';

    }









    public function styles(Worksheet $sheet)
    {



        /*
        |--------------------------------------------------------------------------
        | JUDUL
        |--------------------------------------------------------------------------
        */


        $sheet->insertNewRowBefore(1,3);





        $sheet->mergeCells(
            'A1:E1'
        );


        $sheet->mergeCells(
            'A2:E2'
        );







        $sheet->setCellValue(

            'A1',

            'CV SAHABAT ALAM'

        );






        $sheet->setCellValue(

            'A2',

            'LAPORAN DANA MASUK PROJECT'

        );








        $sheet->getStyle(

            'A1:E2'

        )
        ->getFont()
        ->setBold(true)
        ->setSize(16);







        $sheet->getStyle(

            'A1:E2'

        )
        ->getAlignment()
        ->setHorizontal(

            'center'

        );









        /*
        |--------------------------------------------------------------------------
        | HEADER TABLE
        |--------------------------------------------------------------------------
        */


        $sheet->getStyle(

            'A4:E4'

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

            'A4:E4'

        )
        ->getFont()
        ->setBold(true)
        ->getColor()
        ->setARGB(

            'FFFFFF'

        );









        /*
        |--------------------------------------------------------------------------
        | FORMAT RUPIAH
        |--------------------------------------------------------------------------
        */


        $lastRow = $sheet->getHighestRow();





        $sheet->getStyle(

            "D5:D$lastRow"

        )
        ->getNumberFormat()
        ->setFormatCode(

            '"Rp" #,##0'

        );









        /*
        |--------------------------------------------------------------------------
        | TOTAL ROW
        |--------------------------------------------------------------------------
        */


        $sheet->getStyle(

            "A$lastRow:E$lastRow"

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

            "A$lastRow:E$lastRow"

        )
        ->getFont()
        ->setBold(true);









        /*
        |--------------------------------------------------------------------------
        | BORDER
        |--------------------------------------------------------------------------
        */


        $sheet->getStyle(

            "A4:E$lastRow"

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
        | FREEZE & FILTER
        |--------------------------------------------------------------------------
        */


        $sheet->freezePane(

            'A5'

        );




        $sheet->setAutoFilter(

            'A4:E'.($lastRow-1)

        );







        return $sheet;


    }









    public function columnWidths(): array
    {


        return [


            'A'=>18,


            'B'=>35,


            'C'=>18,


            'D'=>25,


            'E'=>30,


        ];


    }



}