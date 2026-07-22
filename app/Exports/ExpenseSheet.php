<?php

namespace App\Exports;


use App\Models\TransaksiDana;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;


use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;



class ExpenseSheet implements
FromCollection,
WithTitle,
WithStyles,
WithColumnWidths
{


    public function collection()
    {


        $data = TransaksiDana::with([


            'pengajuanDana.proyek',


            'pengajuanDana.divisi',


            'pengajuanDana.pengguna',


            'penyetuju',


            'rekeningBank'


        ])

        ->latest()

        ->get()

        ->map(function($expense){



            return [



                'Tanggal' => date(

                    'd M Y',

                    strtotime(

                        $expense->tanggal

                    )

                ),





                'Pemohon' =>


                    $expense

                    ->pengajuanDana

                    ->pengguna

                    ->name ?? '-',






                'Project' =>


                    $expense

                    ->pengajuanDana

                    ->proyek

                    ->nama_proyek ?? '-',






                'Divisi' =>


                    $expense

                    ->pengajuanDana

                    ->divisi

                    ->nama_divisi ?? '-',






                'Bank' =>


                    $expense

                    ->rekeningBank

                    ->nama_bank ?? '-',






                'Judul Pengajuan' =>


                    $expense

                    ->pengajuanDana

                    ->judul ?? '-',






                'Nominal' =>


                    $expense->jumlah,








                'Disetujui Oleh' =>


                    $expense

                    ->penyetuju

                    ->name ?? '-',






                'Status' =>


                    'Approved'



            ];



        });









        /*
        |--------------------------------------------------------------------------
        | TOTAL PENGELUARAN
        |--------------------------------------------------------------------------
        */


        $data->push([



            'Tanggal'=>'',



            'Pemohon'=>'',



            'Project'=>'',



            'Divisi'=>'',



            'Bank'=>'',



            'Judul Pengajuan'=>'TOTAL PENGELUARAN',



            'Nominal'=>$data->sum('Nominal'),



            'Disetujui Oleh'=>'',



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

            'Bank',

            'Judul Pengajuan',

            'Nominal',

            'Disetujui Oleh',

            'Status'


        ];


    }









    public function title():string
    {


        return 'Pengeluaran';


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

            'A1:I1'

        );



        $sheet->mergeCells(

            'A2:I2'

        );






        $sheet->setCellValue(

            'A1',

            'CV SAHABAT ALAM'

        );





        $sheet->setCellValue(

            'A2',

            'LAPORAN PENGELUARAN KEUANGAN'

        );









        $sheet->getStyle(

            'A1:I2'

        )

        ->getFont()

        ->setBold(true)

        ->setSize(16);








        $sheet->getStyle(

            'A1:I2'

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

            'A4:I4'

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

            'A4:I4'

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

            "G5:G$lastRow"

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

            "A$lastRow:I$lastRow"

        )

        ->getFill()

        ->setFillType(

            Fill::FILL_SOLID

        )

        ->getStartColor()

        ->setARGB(

            'FEE2E2'

        );






        $sheet->getStyle(

            "A$lastRow:I$lastRow"

        )

        ->getFont()

        ->setBold(true);









        /*
        |--------------------------------------------------------------------------
        | BORDER
        |--------------------------------------------------------------------------
        */


        $sheet->getStyle(

            "A4:I$lastRow"

        )

        ->getBorders()

        ->getAllBorders()

        ->setBorderStyle(

            Border::BORDER_THIN

        );









        /*
        |--------------------------------------------------------------------------
        | STATUS
        |--------------------------------------------------------------------------
        */


        for($i = 5; $i < $lastRow; $i++)

        {


            $sheet->getStyle(

                "I$i"

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

            "A4:I".($lastRow-1)

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


            'E'=>18,


            'F'=>35,


            'G'=>20,


            'H'=>25,


            'I'=>15,


        ];


    }


}