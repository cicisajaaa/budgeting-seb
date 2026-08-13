<?php

namespace App\Exports;


use App\Models\ProjectDeposit;
use App\Models\ExpenseRequest;
use App\Models\Proyek;


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



class FinanceSummarySheet implements

    FromArray,

    WithEvents,

    WithDrawings,

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

        return 'Ringkasan Keuangan';

    }






    public function startCell(): string
    {

        return 'A6';

    }









public function array(): array
{


$pendapatan = ProjectDeposit::when(

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




$pengeluaran = ExpenseRequest::when(

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

->where(
    'status',
    'approved'
)

->sum('jumlah');

        $pengeluaran = ExpenseRequest::where(
            'status',
            'approved'
        )
        ->sum('jumlah');



        $saldo = $pendapatan - $pengeluaran;



       $totalProject = Proyek::when(

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

->count();



        $projectAktif = Proyek::where(
            'progres_keseluruhan',
            '<',
            100
        )
        ->count();




        $totalAnggaran = Proyek::sum(
            'total_anggaran'
        );



        $efisiensi = 0;


        if($totalAnggaran > 0)
        {

            $efisiensi =
            ($saldo / $totalAnggaran) * 100;

        }






        return [


            [

                'Keterangan',

                'Nilai',

                'Status'

            ],




            [

                'Total Pendapatan',

                $pendapatan,

                'Positif'

            ],




            [

                'Total Pengeluaran',

                $pengeluaran,

                'Pengeluaran'

            ],




            [

                'Saldo Bersih',

                $saldo,

                'Stabil'

            ],




            [
ProjectDeposit::when(

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

->count()


+

ExpenseRequest::when(

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

->count()

            ],




            [

                'Total Project',

                $totalProject,

                'Project'

            ],





            [

                'Project Aktif',

                $projectAktif,

                'Berjalan'

            ],





            [

                'Total Anggaran Project',

                $totalAnggaran,

                'Budget'

            ],




            [

                'Efisiensi Dana',

                number_format(
                    $efisiensi,
                    2
                ).' %',

                'Evaluasi'

            ],


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



    // ukuran sama dengan summary
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
                HEADER
                */


                $sheet->mergeCells(
                    'B1:H1'
                );


                $sheet->mergeCells(
                    'B2:H2'
                );



                $sheet->setCellValue(
                    'B1',
                    'CV SAHABAT EKSPLORASI BANUA'
                );



                $sheet->setCellValue(
                    'B2',
                    'RINGKASAN KEUANGAN PERUSAHAAN'
                );




                $sheet->mergeCells(
                    'B3:H3'
                );


                $sheet->setCellValue(
                    'B3',
                    'Periode : '.now()->format('d M Y')
                );






                $sheet->getStyle(
                    'B1:H3'
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
                    'A6:C6'
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









                /*
                BORDER
                */


                $lastRow = $sheet->getHighestRow();



                $sheet->getStyle(
                    'A6:C'.$lastRow
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
                    'B7:B9'
                )
                ->getNumberFormat()
                ->setFormatCode(
                    '"Rp" #,##0'
                );





                $sheet->getStyle(
                    'B7:B14'
                )
                ->getAlignment()
                ->setHorizontal(
                    Alignment::HORIZONTAL_CENTER
                );






                /*
                WARNA BARIS
                */


                $sheet->getStyle(
                    'A7:C7'
                )
                ->applyFromArray([


                    'fill'=>[

                        'fillType'=>Fill::FILL_SOLID,

                        'startColor'=>[
                            'rgb'=>'DCFCE7'
                        ]

                    ]

                ]);




                $sheet->getStyle(
                    'A8:C8'
                )
                ->applyFromArray([


                    'fill'=>[

                        'fillType'=>Fill::FILL_SOLID,

                        'startColor'=>[
                            'rgb'=>'FEE2E2'
                        ]

                    ]

                ]);





                $sheet->getStyle(
                    'A9:C9'
                )
                ->applyFromArray([


                    'fill'=>[

                        'fillType'=>Fill::FILL_SOLID,

                        'startColor'=>[
                            'rgb'=>'BBF7D0'
                        ]

                    ],


                    'font'=>[

                        'bold'=>true

                    ]

                ]);








                $sheet->getStyle(
                    'A14:C14'
                )
                ->applyFromArray([


                    'fill'=>[

                        'fillType'=>Fill::FILL_SOLID,

                        'startColor'=>[
                            'rgb'=>'FEF3C7'
                        ]

                    ]

                ]);









                /*
                COLUMN
                */


                $sheet->getColumnDimension('A')
                    ->setWidth(30);



                $sheet->getColumnDimension('B')
                    ->setWidth(22);



                $sheet->getColumnDimension('C')
                    ->setWidth(18);







                /*
                HEIGHT
                */



                $sheet->getRowDimension(1)
                    ->setRowHeight(45);



                $sheet->getRowDimension(2)
                    ->setRowHeight(30);



                $sheet->getRowDimension(6)
                    ->setRowHeight(25);







                $sheet->freezePane(
                    'A7'
                );


            }


        ];

    }



}