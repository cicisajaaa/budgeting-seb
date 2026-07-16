<?php

namespace App\Exports;


use App\Models\ProjectDeposit;
use App\Models\ExpenseTransaction;
use App\Models\Project;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;


use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;


use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;




class DashboardSheet implements
FromCollection,
WithTitle,
WithStyles,
WithColumnWidths
{


    public function collection()
    {


        $income = ProjectDeposit::sum(
            'jumlah_setoran'
        );


        $expense = ExpenseTransaction::sum(
            'jumlah'
        );


        $balance = $income - $expense;




        return collect([


            [
                '',
                'CV SAHABAT ALAM',
                '',
                '',
                ''
            ],



            [
                '',
                'FINANCIAL REPORT SYSTEM',
                '',
                '',
                ''
            ],



            [
                '',
                'Laporan Keuangan',
                date('d M Y'),
                '',
                ''
            ],



            [
                '',
                '',
                '',
                '',
                ''
            ],





            [
                'KETERANGAN',
                'NILAI',
                'STATUS',
                '',
                ''
            ],






            [
                'TOTAL PEMASUKAN',
                $income,
                'Dana Masuk',
                '',
                ''
            ],




            [
                'TOTAL PENGELUARAN',
                $expense,
                'Dana Keluar',
                '',
                ''
            ],




            [
                'SALDO AKHIR',
                $balance,
                'Dana Tersedia',
                '',
                ''
            ],





            [
                'JUMLAH PROJECT',
                Project::count(),
                'Project Aktif',
                '',
                ''
            ],



        ]);



    }





    public function title(): string
    {

        return "Dashboard";

    }








    public function styles(Worksheet $sheet)
    {



        /*
        |--------------------------------------------------------------------------
        | HEADER JUDUL
        |--------------------------------------------------------------------------
        */


        $sheet->mergeCells(
            'B1:E1'
        );


        $sheet->mergeCells(
            'B2:E2'
        );


        $sheet->mergeCells(
            'B3:C3'
        );





        $sheet->getStyle(
            'B1:E2'
        )
        ->getFont()
        ->setBold(true)
        ->setSize(18);




        $sheet->getStyle(
            'B1:E3'
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
            'A5:C5'
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
            'A5:C5'
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


        $sheet->getStyle(
            'B6:B8'
        )
        ->getNumberFormat()
        ->setFormatCode(
            '"Rp" #,##0'
        );








        /*
        |--------------------------------------------------------------------------
        | BORDER TABLE
        |--------------------------------------------------------------------------
        */


        $sheet->getStyle(
            'A5:C9'
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


            $drawing->setDescription(
                'CV Sahabat Alam'
            );


            $drawing->setPath(
                $logo
            );


            $drawing->setHeight(
                55
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
        | CHART
        |--------------------------------------------------------------------------
        */


        $labels = [

            new DataSeriesValues(
                'String',
                'Dashboard!$A$6',
                null,
                1
            ),

            new DataSeriesValues(
                'String',
                'Dashboard!$A$7',
                null,
                1
            )

        ];






        $categories = [

            new DataSeriesValues(
                'String',
                'Dashboard!$A$6:$A$7',
                null,
                2
            )

        ];







        $values = [

            new DataSeriesValues(
                'Number',
                'Dashboard!$B$6:$B$7',
                null,
                2
            )

        ];







        $series = new DataSeries(

            DataSeries::TYPE_BARCHART,

            DataSeries::GROUPING_CLUSTERED,

            range(
                0,
                count($values)-1
            ),

            $labels,

            $categories,

            $values

        );







        $plotArea = new PlotArea(

            null,

            [
                $series
            ]

        );






        $legend = new Legend(
            Legend::POSITION_RIGHT,
            null,
            false
        );





        $title = new Title(
            'Pemasukan vs Pengeluaran'
        );





        $chart = new Chart(

            'finance_chart',

            $title,

            $legend,

            $plotArea

        );





        $chart->setTopLeftPosition(
            'E5'
        );



        $chart->setBottomRightPosition(
            'L20'
        );



        $sheet->addChart(
            $chart
        );








        /*
        |--------------------------------------------------------------------------
        | FREEZE
        |--------------------------------------------------------------------------
        */


        $sheet->freezePane(
            'A6'
        );



        return $sheet;


    }







    public function columnWidths(): array
    {


        return [

            'A'=>30,

            'B'=>28,

            'C'=>22,

            'D'=>15,

            'E'=>15,

            'F'=>15,

            'G'=>15,

            'H'=>15,

        ];

    }


}