<?php

namespace App\Notifications;


use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;



class NewExpenseRequest extends Notification
{

    use Queueable;



    public $pengajuan;




    public function __construct($pengajuan)
    {

        $this->pengajuan = $pengajuan;

    }







    public function via($notifiable)
    {

        return [

            'database'

        ];

    }







    public function toDatabase($notifiable)
    {


        return [


            'title' =>

                'Pengajuan Dana Baru',





            'message' =>


                ($this->pengajuan->pengguna->name ?? 'Karyawan')

                .

                ' mengajukan dana sebesar Rp '

                .

                number_format(

                    $this->pengajuan->jumlah,

                    0,

                    ',',

                    '.'

                ),






            'project' =>


                $this->pengajuan->proyek->nama_proyek ?? '-',






            'division' =>


                $this->pengajuan->divisi->nama_divisi ?? '-',






            'jumlah' =>


                $this->pengajuan->jumlah,






            'expense_id' =>


                $this->pengajuan->id,







            'url' =>

                route(

                    'expense.approval'

                ),





        ];


    }


}