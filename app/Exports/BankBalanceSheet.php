<?php

namespace App\Exports;


use App\Models\BankAccount;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;


use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;



class BankBalanceSheet implements
FromCollection,
WithTitle,
WithStyles,
WithColumnWidths
{


    public function collection()
    {


        $data = BankAccount::where(
            'status',
            true
        )
        ->latest()
        ->get()
        ->map(function($bank){


            return [


                'Bank' =>

                $bank->nama_bank,



                'Nomor Rekening' =>

                $bank->nomor_rekening,



                'Nama Pemilik' =>

                $bank->nama_pemilik,



                'Saldo Bank' =>

                $bank->saldo,



                'Status' =>

                $bank->saldo > 0

                ? 'Tersedia'

                : 'Kosong'


            ];


        });







        /*
        |--------------------------------------------------------------------------
        | TOTAL SALDO BANK
        |--------------------------------------------------------------------------
        */


        $data->push([


            'Bank'=>'',

            'Nomor Rekening'=>'',

            'Nama Pemilik'=>'TOTAL SALDO BANK',

            'Saldo Bank'=>$data->sum('Saldo Bank'),

            'Status'=>'Total'


        ]);







        return $data;


    }









    public function headings():array
    {


        return [


            'Bank',

            'Nomor Rekening',

            'Nama Pemilik',

            'Saldo Bank',

            'Status'


        ];

    }









    public function title():string
    {


        return 'Saldo Bank';


    }









    public function styles(Worksheet $sheet)
    {



        /*
        |--------------------------------------------------------------------------
        | HEADER LAPORAN
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

            'LAPORAN SALDO REKENING BANK'

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
        | STATUS COLOR
        |--------------------------------------------------------------------------
        */


        for($i=5;$i<$lastRow;$i++)

        {


            $status =

            $sheet->getCell(

                "E$i"

            )->getValue();






            if($status=="Tersedia")
            {


                $sheet->getStyle(

                    "E$i"

                )
                ->getFill()
                ->setFillType(

                    Fill::FILL_SOLID

                )
                ->getStartColor()
                ->setARGB(

                    'DCFCE7'

                );


            }
            else
            {


                $sheet->getStyle(

                    "E$i"

                )
                ->getFill()
                ->setFillType(

                    Fill::FILL_SOLID

                )
                ->getStartColor()
                ->setARGB(

                    'FEE2E2'

                );


            }


        }









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
        | FREEZE + FILTER
        |--------------------------------------------------------------------------
        */


        $sheet->freezePane(

            'A5'

        );





        $sheet->setAutoFilter(

            "A4:E".($lastRow-1)

        );







        return $sheet;


    }









    public function columnWidths():array
    {


        return [


            'A'=>20,


            'B'=>25,


            'C'=>30,


            'D'=>25,


            'E'=>18,


        ];


    }



}