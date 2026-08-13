<?php

namespace App\Exports;


use App\Models\ProjectDeposit;
use App\Models\ExpenseRequest;


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


class FinanceTransactionSheet implements

    FromCollection,

    WithHeadings,

    WithMapping,

    WithEvents,

    WithDrawings,

    WithColumnWidths,

    WithTitle,

    WithCustomStartCell

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


    public function title(): string
    {

        return 'Transaksi Keuangan';

    }







    public function startCell(): string
    {

        return 'A6';

    }








    public function collection()
{


    $pemasukan = ProjectDeposit::with('proyek')

        ->when(

            $this->startDate,

            function($query){

                $query->whereDate(
                    'tanggal_setoran',
                    '>=',
                    $this->startDate
                );

            }

        )

        ->when(

            $this->endDate,

            function($query){

                $query->whereDate(
                    'tanggal_setoran',
                    '<=',
                    $this->endDate
                );

            }

        )

        ->latest()

        ->get();





    $pengeluaran = ExpenseRequest::with('proyek')

        ->where(
            'status',
            'approved'
        )

        ->when(

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






return $pemasukan
    ->concat($pengeluaran)
    ->sortByDesc(function($item){

        return $item instanceof ProjectDeposit
            ? $item->tanggal_setoran
            : $item->created_at;

    })
    ->values();

return $pemasukan
    ->concat($pengeluaran)
    ->sortByDesc(function($item){

        return $item instanceof ProjectDeposit
            ? $item->tanggal_setoran
            : $item->created_at;

    })
    ->values();
}









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









    public function map($row): array
    {


        if(
            isset($row->jumlah_setoran)
        )
        {


            return [

            $row->tanggal_setoran
            ? \Carbon\Carbon::parse($row->tanggal_setoran)->format('d M Y')
            : '-',



                'Pemasukan',



                $row->proyek->nama_proyek ?? '-',



                'Setoran Proyek',



                $row->jumlah_setoran ?? 0


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


$sheet = $event->sheet->getDelegate();



/*
HEADER
*/


$sheet->mergeCells('B1:E1');

$sheet->mergeCells('B2:E2');



$sheet->setCellValue(
    'B1',
    'CV SAHABAT EKSPLORASI BANUA'
);



$sheet->setCellValue(
    'B2',
    'DETAIL TRANSAKSI KEUANGAN'
);




$sheet->getStyle('B1:E2')
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


$sheet->getStyle('A6:E6')
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





/*
BORDER
*/


$lastRow = $sheet->getHighestRow();


$sheet->getStyle(
    'A6:E'.$lastRow
)
->applyFromArray([


'borders'=>[


'allBorders'=>[

    'borderStyle'=>'thin',

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
    'A7:D'.$lastRow
)
->getAlignment()
->setVertical(
    Alignment::VERTICAL_CENTER
);



$sheet->getStyle(
    'E7:E'.$lastRow
)
->getAlignment()
->setHorizontal(
    Alignment::HORIZONTAL_RIGHT
);





/*
FORMAT RUPIAH
*/


$sheet->getStyle(
    'E7:E'.$lastRow
)
->getNumberFormat()
->setFormatCode(

'"Rp" #,##0'

);







/*
TOTAL
*/

$totalMasuk = ProjectDeposit::when(

    $this->startDate,

    function($query){

        $query->whereDate(
            'tanggal_setoran',
            '>=',
            $this->startDate
        );

    }

)

->when(

    $this->endDate,

    function($query){

        $query->whereDate(
            'tanggal_setoran',
            '<=',
            $this->endDate
        );

    }

)

->sum('jumlah_setoran');






$totalKeluar = ExpenseRequest::where(
    'status',
    'approved'
)

->when(

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

->sum('jumlah');



$row = $lastRow + 2;



$sheet->setCellValue(
    'D'.$row,
    'TOTAL PEMASUKAN'
);


$sheet->setCellValue(
    'E'.$row,
    $totalMasuk
);



$sheet->setCellValue(
    'D'.($row+1),
    'TOTAL PENGELUARAN'
);


$sheet->setCellValue(
    'E'.($row+1),
    $totalKeluar
);



$sheet->setCellValue(
    'D'.($row+2),
    'SALDO'
);


$sheet->setCellValue(
    'E'.($row+2),
    $totalMasuk-$totalKeluar
);




$sheet->getStyle(
    'D'.$row.':E'.($row+2)
)
->applyFromArray([


'font'=>[

    'bold'=>true

],


'borders'=>[


'allBorders'=>[

    'borderStyle'=>'thin',

    'color'=>[
        'rgb'=>'D1D5DB'
    ]

]


]


]);





// highlight saldo

$sheet->getStyle(
    'D'.($row+2).':E'.($row+2)
)
->applyFromArray([


'fill'=>[

    'fillType'=>Fill::FILL_SOLID,

    'startColor'=>[
        'rgb'=>'DCFCE7'
    ]

]


]);






/*
COLUMN
*/


$sheet->getColumnDimension('A')
->setWidth(18);


$sheet->getColumnDimension('B')
->setWidth(22);


$sheet->getColumnDimension('C')
->setWidth(32);


$sheet->getColumnDimension('D')
->setWidth(35);


$sheet->getColumnDimension('E')
->setWidth(20);





/*
ROW
*/


$sheet->getRowDimension(1)
->setRowHeight(40);



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


            'A'=>18,

            'B'=>22,

            'C'=>32,

            'D'=>35,

            'E'=>20


        ];

    }



}