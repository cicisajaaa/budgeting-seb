<?php

namespace App\Exports;

use App\Models\TransaksiDana;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

use Maatwebsite\Excel\Events\AfterSheet;

use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;


class FinanceExpenseExport implements
    FromArray,
    WithCustomStartCell,
    WithEvents,
    WithColumnWidths
{

    protected $companyName = 'NAMA PERUSAHAAN';

    protected $totalExpense = 0;

    protected $totalTransaction = 0;



    public function startCell(): string
    {
        return 'A9';
    }





    public function array(): array
    {

        $rows = [];


        $transactions = TransaksiDana::with([

            'pengajuanDana.proyek.perusahaan',

            'pengajuanDana.divisi',

            'pengajuanDana.pengguna',

            'rekeningBank'

        ])

        ->latest('tanggal')

        ->get();



        $this->totalTransaction =
            $transactions->count();


        $this->totalExpense =
            $transactions->sum('jumlah');




        if($transactions->first()?->pengajuanDana?->proyek?->perusahaan)

        {

            $this->companyName =
                $transactions
                ->first()
                ->pengajuanDana
                ->proyek
                ->perusahaan
                ->nama_perusahaan;

        }





        foreach($transactions as $index=>$transaction)

        {

            $rows[] = [

                $index + 1,

                $transaction->tanggal
                ?
                $transaction->tanggal->format('d-m-Y')
                :
                '-',

                $transaction->pengajuanDana->nomor_pengajuan ?? '-',

                $transaction->pengajuanDana->pengguna->name ?? '-',

                $transaction->pengajuanDana->proyek->nama_proyek ?? '-',

                $transaction->pengajuanDana->divisi->nama_divisi ?? '-',

                $transaction->rekeningBank->nama_bank ?? '-',

                $transaction->rekeningBank->nomor_rekening ?? '-',

                $transaction->jumlah ?? 0

            ];

        }


        return $rows;

    }





    public function columnWidths(): array

    {

        return [

            'A'=>7,

            'B'=>15,

            'C'=>22,

            'D'=>20,

            'E'=>25,

            'F'=>15,

            'G'=>18,

            'H'=>22,

            'I'=>18,

        ];

    }


    public function registerEvents(): array
{

    return [

    AfterSheet::class => function(AfterSheet $event){


        $sheet = $event->sheet->getDelegate();


        $lastRow = 9 + $this->totalTransaction;



        /*
        =========================
        HEADER LAPORAN
        =========================
        */


        $sheet->mergeCells('A1:I1');

        $sheet->setCellValue(
            'A1',
            strtoupper($this->companyName)
        );


        $sheet->mergeCells('A2:I2');

        $sheet->setCellValue(
            'A2',
            'LAPORAN PENGELUARAN DANA'
        );


        $sheet->mergeCells('A3:I3');

        $sheet->setCellValue(
            'A3',
            'FINANCE & ACCOUNTING DEPARTMENT'
        );


        $sheet->mergeCells('A4:I4');

        $sheet->setCellValue(
            'A4',
            'Tanggal Cetak : '.now()->format('d F Y')
        );





        /*
        =========================
        INFORMASI
        =========================
        */


        $sheet->setCellValue(
            'A6',
            'Total Transaksi'
        );


        $sheet->setCellValue(
            'B6',
            $this->totalTransaction.' transaksi'
        );


        $sheet->setCellValue(
            'D6',
            'Total Pengeluaran'
        );


        $sheet->setCellValue(
            'E6',
            $this->totalExpense
        );





        /*
        =========================
        HEADER TABLE
        =========================
        */


        $sheet->fromArray(

            [[

                'No',
                'Tanggal',
                'Nomor Pengajuan',
                'Pemohon',
                'Project',
                'Divisi',
                'Bank',
                'Nomor Rekening',
                'Nominal'

            ]],

            null,

            'A8'

        );





        /*
        =========================
        STYLE HEADER
        =========================
        */


        $sheet->getStyle('A1:I4')

        ->getAlignment()

        ->setHorizontal(
            Alignment::HORIZONTAL_CENTER
        );



        $sheet->getStyle('A1')

        ->getFont()

        ->setBold(true)

        ->setSize(16);



        $sheet->getStyle('A2')

        ->getFont()

        ->setBold(true)

        ->setSize(14);



        $sheet->getStyle('A3:I4')

        ->getFont()

        ->setSize(10);






        /*
        =========================
        INFO STYLE
        =========================
        */


        $sheet->getStyle('A6:E6')

        ->getBorders()

        ->getAllBorders()

        ->setBorderStyle(
            Border::BORDER_THIN
        );


        $sheet->getStyle('A6:D6')

        ->getFont()

        ->setBold(true);



        $sheet->getStyle('A6')

        ->getFill()

        ->setFillType(Fill::FILL_SOLID)

        ->getStartColor()

        ->setRGB('E2E8F0');



        $sheet->getStyle('D6')

        ->getFill()

        ->setFillType(Fill::FILL_SOLID)

        ->getStartColor()

        ->setRGB('E2E8F0');



        $sheet->getStyle('E6')

        ->getNumberFormat()

        ->setFormatCode('"Rp" #,##0');






        /*
        =========================
        TABLE HEADER
        =========================
        */


        $sheet->getStyle('A8:I8')

        ->getFont()

        ->setBold(true)

        ->getColor()

        ->setRGB('FFFFFF');



        $sheet->getStyle('A8:I8')

        ->getFill()

        ->setFillType(Fill::FILL_SOLID)

        ->getStartColor()

        ->setRGB('1E293B');



        $sheet->getStyle('A8:I8')

        ->getAlignment()

        ->setHorizontal(
            Alignment::HORIZONTAL_CENTER
        );






        /*
        =========================
        DATA STYLE
        =========================
        */


        if($this->totalTransaction > 0)

        {

            for($i=9;$i<=$lastRow;$i++)

            {

                if($i % 2 == 1)

                {

                    $sheet->getStyle(
                        "A{$i}:I{$i}"
                    )

                    ->getFill()

                    ->setFillType(Fill::FILL_SOLID)

                    ->getStartColor()

                    ->setRGB('F8FAFC');

                }

            }



            $sheet->getStyle(
                "A9:A".$lastRow
            )

            ->getAlignment()

            ->setHorizontal(
                Alignment::HORIZONTAL_CENTER
            );



            $sheet->getStyle(
                "I9:I".$lastRow
            )

            ->getNumberFormat()

            ->setFormatCode('"Rp" #,##0');


        }





        $sheet->getStyle(
            "A8:I".$lastRow
        )

        ->getBorders()

        ->getAllBorders()

        ->setBorderStyle(
            Border::BORDER_THIN
        );







        /*
        =========================
        TOTAL
        =========================
        */


        $totalRow = $lastRow + 2;



        $sheet->mergeCells(
            "A{$totalRow}:H{$totalRow}"
        );


        $sheet->setCellValue(
            "A{$totalRow}",
            'TOTAL PENGELUARAN'
        );


        $sheet->setCellValue(
            "I{$totalRow}",
            $this->totalExpense
        );



        $sheet->getStyle(
            "A{$totalRow}:I{$totalRow}"
        )

        ->getFont()

        ->setBold(true);



        $sheet->getStyle(
            "A{$totalRow}:I{$totalRow}"
        )

        ->getFill()

        ->setFillType(Fill::FILL_SOLID)

        ->getStartColor()

        ->setRGB('E2E8F0');



        $sheet->getStyle(
            "I{$totalRow}"
        )

        ->getNumberFormat()

        ->setFormatCode('"Rp" #,##0');






        /*
        =========================
        SIGNATURE
        =========================
        */


        $sign = $totalRow + 4;



        $sheet->setCellValue(
            "C{$sign}",
            'Disusun Oleh'
        );


        $sheet->setCellValue(
            "G{$sign}",
            'Disetujui Oleh'
        );



        $sheet->setCellValue(
            "C".($sign+3),
            'Finance'
        );


        $sheet->setCellValue(
            "G".($sign+3),
            'Manager'
        );



        $sheet->getStyle(
            "C{$sign}:G".($sign+3)
        )

        ->getAlignment()

        ->setHorizontal(
            Alignment::HORIZONTAL_CENTER
        );







        /*
        =========================
        SETTING
        =========================
        */


        $sheet->freezePane('A9');


        $sheet->setAutoFilter(
            "A8:I".$lastRow
        );


        $sheet->setShowGridlines(false);



        $sheet->getPageSetup()

        ->setOrientation(
            PageSetup::ORIENTATION_LANDSCAPE
        );


        $sheet->getPageSetup()

        ->setPaperSize(
            PageSetup::PAPERSIZE_A4
        );


    }

    ];

}


}