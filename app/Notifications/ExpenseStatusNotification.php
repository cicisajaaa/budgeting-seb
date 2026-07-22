<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;


class ExpenseStatusNotification extends Notification
{

    use Queueable;


    public $pengajuan;

    public $status;



    public function __construct($pengajuan, $status)
    {

        $this->pengajuan = $pengajuan;

        $this->status = $status;

    }





    public function via($notifiable)
    {

        return [

            'database'

        ];

    }







    public function toDatabase($notifiable)
    {

        if($this->status == 'approved')
        {

            $title = "Pengajuan Dana Disetujui";


            $message =

                "Pengajuan dana Rp ".

                number_format(
                    $this->pengajuan->jumlah
                ).

                " telah disetujui.";

        }
        else
        {

            $title = "Pengajuan Dana Ditolak";


            $message =

                "Pengajuan dana Rp ".

                number_format(
                    $this->pengajuan->jumlah
                ).

                " ditolak.";

        }



        return [

            'title' => $title,


            'message' => $message,


            'url' => route(
                'expense.myhistory'
            ),


            'pengajuan_id' => $this->pengajuan->id

        ];

    }


}